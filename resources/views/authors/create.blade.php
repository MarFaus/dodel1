@extends('layouts.app')

@section('title', 'Добавить автора')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h1 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem;">Добавление автора</h1>

    <form action="{{ route('authors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>ФИО / Имя автора *</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Страна</label>
                <input type="text" name="country" value="{{ old('country') }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Дата рождения</label>
                <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label>Биография / Краткие сведения</label>
            <textarea name="biography" class="form-control" rows="4">{{ old('biography') }}</textarea>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Сохранить автора</button>
            <a href="{{ route('authors.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection