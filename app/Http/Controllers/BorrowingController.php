<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Reader;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['book.author', 'reader']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->latest()->paginate(10)->withQueryString();

        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $books = Book::where('available', true)->get();
        $readers = Reader::orderBy('full_name')->get();

        return view('borrowings.create', compact('books', 'readers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'reader_id' => 'required|exists:readers,id',
            'borrowed_at' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:borrowed_at',
        ]);

        $book = Book::findOrFail($validated['book_id']);
        if ($book->available_quantity <= 0) {
            return redirect()->back()->withInput()->with('error', 'Все экземпляры этой книги сейчас выданы!');
        }

        Borrowing::create([
            'book_id' => $validated['book_id'],
            'reader_id' => $validated['reader_id'],
            'borrowed_at' => $validated['borrowed_at'],
            'return_date' => $validated['return_date'],
            'status' => 'borrowed',
        ]);

        return redirect()->route('borrowings.index')->with('success', 'Книга успешно выдана!');
    }

    public function returnBook(Borrowing $borrowing)
    {
        $borrowing->update([
            'status' => 'returned',
            'returned_at' => now()->toDateString(),
        ]);

        return redirect()->route('borrowings.index')->with('success', 'Книга успешно возвращена!');
    }

    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return redirect()->route('borrowings.index')->with('success', 'Запись о выдаче удалена!');
    }
}