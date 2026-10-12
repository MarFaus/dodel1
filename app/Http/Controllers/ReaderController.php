<?php

namespace App\Http\Controllers;

use App\Models\Reader;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    public function index(Request $request)
    {
        $query = Reader::withCount('borrowings');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $readers = $query->latest()->paginate(10)->withQueryString();

        return view('readers.index', compact('readers'));
    }

    public function create()
    {
        return view('readers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
        ]);

        Reader::create($validated);

        return redirect()->route('readers.index')->with('success', 'Читатель успешно зарегистрирован!');
    }

    public function show(Reader $reader)
    {
        $reader->load(['borrowings.book']);
        return view('readers.show', compact('reader'));
    }

    public function edit(Reader $reader)
    {
        return view('readers.edit', compact('reader'));
    }

    public function update(Request $request, Reader $reader)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
        ]);

        $reader->update($validated);

        return redirect()->route('readers.index')->with('success', 'Данные читателя обновлены!');
    }

    public function destroy(Reader $reader)
    {
        $reader->delete();
        return redirect()->route('readers.index')->with('success', 'Читатель удален!');
    }
}