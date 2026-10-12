<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'genre',
        'year',
        'isbn',
        'quantity',
        'available',
        'description',
    ];

    protected $casts = [
        'available' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function getAvailableQuantityAttribute()
    {
        $borrowedCount = $this->borrowings()->where('status', 'borrowed')->count();
        return max(0, $this->quantity - $borrowedCount);
    }
}