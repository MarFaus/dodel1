<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seat extends Model
{
    protected $fillable = ['hall_id', 'row_number', 'seat_number', 'zone'];

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }
}