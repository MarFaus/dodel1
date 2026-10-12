<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'hall_id', 'title', 'category', 'description', 'start_at', 
        'duration_minutes', 'age_limit', 'prices', 'status', 'bg_gradient'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'prices' => 'array',
        'bg_gradient' => 'array',
    ];

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}