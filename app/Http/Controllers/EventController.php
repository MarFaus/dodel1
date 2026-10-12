<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '\%' .$request->search . '%');
        }

        $events =$query->latest()->get();

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $data =$request->validate([
            'name' => 'required|string|max:200',
            'event_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:5000',
        ]);

        Event::create($data);

        return redirect()
            ->route('events.index')
            ->with('success', 'Мероприятие успешно создано.');
    }
}