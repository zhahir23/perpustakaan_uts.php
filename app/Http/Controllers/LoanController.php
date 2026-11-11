<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Book;
use App\Models\LoanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['member', 'user', 'loanDetails.book'])
            ->latest()
            ->paginate(10);

        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $members = Member::where('status', 'active')
            ->orderBy('name')
            ->get();

        $books = Book::where('stock', '>', 0)
            ->orderBy('title')
            ->get();

        return view('loans.create', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => [
                'required',
                Rule::exists('members', 'id')->where('status', 'active'),
            ],
            'book_id' => ['required', 'exists:books,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'loan_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:loan_date'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated) {
            $book = Book::whereKey($validated['book_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($book->stock < $validated['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok buku tidak mencukupi.',
                ]);
            }

            $loan = Loan::create([
                'member_id' => $validated['member_id'],
                'user_id' => auth()->id(),
                'loan_date' => $validated['loan_date'],
                'due_date' => $validated['due_date'],
                'status' => 'borrowed',
                'notes' => $validated['notes'] ?? null,
            ]);

            LoanDetail::create([
                'loan_id' => $loan->id,
                'book_id' => $book->id,
                'quantity' => $validated['quantity'],
            ]);

            $book->decrement('stock', $validated['quantity']);
        });

        return redirect()->route('loans.index')
            ->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function update(Request $request, string $id)
    {
        $loan = Loan::with('loanDetails')->findOrFail($id);

        if ($loan->status === 'returned') {
            return redirect()->route('loans.index')
                ->with('error', 'Buku pada transaksi ini sudah dikembalikan.');
        }

        DB::transaction(function () use ($loan) {
            foreach ($loan->loanDetails as $detail) {
                $book = Book::whereKey($detail->book_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $book->increment('stock', $detail->quantity);
            }

            $loan->update([
                'status' => 'returned',
                'return_date' => now()->toDateString(),
            ]);
        });

        return redirect()->route('loans.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}
