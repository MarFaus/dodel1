<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'reader_id',
        'borrowed_at',
        'return_date',
        'returned_at',
        'status',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'return_date' => 'date',
        'returned_at' => 'date',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function reader()
    {
        return $this->belongsTo(Reader::class);
    }
}