@extends('layouts.app')

@section('title', 'Добавить книгу')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h1 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem;">Добавление новой книги</h1>

    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Название книги *</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Автор *</label>
            <select name="author_id" class="form-control" required>
                <option value="">Выберите автора...</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Жанр</label>
                <input type="text" name="genre" value="{{ old('genre') }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Год издания</label>
                <input type="number" name="year" value="{{ old('year') }}" class="form-control">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>ISBN</label>
                <input type="text" name="isbn" value="{{ old('isbn') }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Общее количество *</label>
                <input type="number" name="quantity" value="{{ old('quantity', 1) }}" class="form-control" min="0" required>
            </div>
        </div>

        <div class="form-group">
            <label>Описание</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
            <input type="checkbox" name="available" id="available" value="1" {{ old('available', 1) ? 'checked' : '' }}>
            <label for="available" style="margin-bottom: 0;">Доступна для выдачи</label>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Сохранить книгу</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection