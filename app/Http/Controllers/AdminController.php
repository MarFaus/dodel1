<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Hall;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $halls = Hall::withCount('events')->get();
        return view('admin.index', compact('halls'));
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'hall_id' => 'required|exists:halls,id',
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'start_at' => 'required|date',
            'price_vip' => 'required|numeric',
            'price_parter' => 'required|numeric',
            'price_balcon' => 'required|numeric',
        ]);

        Event::create([
            'hall_id' => $request->hall_id,
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description ?? 'Новое мероприятие',
            'start_at' => $request->start_at,
            'prices' => [
                'vip' => (int)$request->price_vip,
                'parter' => (int)$request->price_parter,
                'balcon' => (int)$request->price_balcon,
            ],
            'bg_gradient' => ['#2A2118', '#0C0C0E'],
        ]);

        return redirect()->route('admin.index')->with('success', 'Новое мероприятие успешно добавлено!');
    }
}