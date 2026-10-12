<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('cat', 'Все');
        $search = $request->query('q');

        $query = Event::with('hall');

        if ($category !== 'Все') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $events = $query->orderBy('start_at', 'asc')->get();

        return view('events.index', compact('events', 'category', 'search'));
    }

    public function show($id)
    {
        $event = Event::with('hall.seats')->findOrFail($id);
        $hall = $event->hall;

        $seatsByRow = $hall->seats->groupBy('row_number');

        $occupiedSeatIds = Ticket::where('event_id', $event->id)
            ->whereHas('order', function ($q) {
                $q->whereIn('status', ['paid', 'pending'])
                  ->where('expires_at', '>', now());
            })
            ->pluck('seat_id')
            ->toArray();

        return view('events.show', compact('event', 'hall', 'seatsByRow', 'occupiedSeatIds'));
    }
}