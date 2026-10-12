@extends('layouts.app')

@section('title', 'Выдать книгу')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h1 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem;">Оформление выдачи книги</h1>

    <form action="{{ route('borrowings.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Выберите книгу *</label>
            <select name="book_id" class="form-control" required>
                <option value="">-- Выберите книгу из списка --</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                        {{ $book->title }} (Доступно: {{ $book->available_quantity }} из {{ $book->quantity }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Выберите читателя *</label>
            <select name="reader_id" class="form-control" required>
                <option value="">-- Выберите читателя из списка --</option>
                @foreach($readers as $reader)
                    <option value="{{ $reader->id }}" {{ old('reader_id') == $reader->id ? 'selected' : '' }}>
                        {{ $reader->full_name }} ({{ $reader->phone ?? 'нет телефона' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Дата выдачи *</label>
                <input type="date" name="borrowed_at" value="{{ old('borrowed_at', date('Y-m-d')) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Плановая дата возврата</label>
                <input type="date" name="return_date" value="{{ old('return_date', date('Y-m-d', strtotime('+14 days'))) }}" class="form-control">
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Выдать книгу</button>
            <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection