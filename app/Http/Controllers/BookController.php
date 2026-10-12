<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('author');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%")
                  ->orWhereHas('author', function ($aq) use ($search) {
                      $aq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        if ($request->filled('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        $books = $query->latest()->paginate(10)->withQueryString();
        $authors = Author::orderBy('name')->get();
        $genres = Book::whereNotNull('genre')->distinct()->pluck('genre');

        return view('books.index', compact('books', 'authors', 'genres'));
    }

    public function create()
    {
        $authors = Author::orderBy('name')->get();
        return view('books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'isbn' => 'nullable|string|max:20',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $validated['available'] = $request->has('available');

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Книга успешно добавлена!');
    }

    public function show(Book $book)
    {
        $book->load(['author', 'borrowings.reader']);
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::orderBy('name')->get();
        return view('books.edit', compact('book', 'authors'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'isbn' => 'nullable|string|max:20',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $validated['available'] = $request->has('available');

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Данные книги обновлены!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Книга удалена!');
    }
}