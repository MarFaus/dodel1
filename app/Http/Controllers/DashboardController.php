<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Reader;

class DashboardController extends Controller
{
    public function index()
    {
        $booksCount = Book::count();
        $authorsCount = Author::count();
        $readersCount = Reader::count();
        $borrowedCount = Borrowing::where('status', 'borrowed')->count();
        $returnedCount = Borrowing::where('status', 'returned')->count();

        $latestBorrowings = Borrowing::with(['book', 'reader'])
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'booksCount',
            'authorsCount',
            'readersCount',
            'borrowedCount',
            'returnedCount',
            'latestBorrowings'
        ));
    }
}