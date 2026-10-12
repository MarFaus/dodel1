@extends('layouts.app')

@section('title', $author->name)

@section('content')
<div class="header-actions">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700;">{{ $author->name }}</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Страна: {{ $author->country ?? '—' }} | Дата рождения: {{ $author->birth_date ? $author->birth_date->format('d.m.Y') : '—' }}</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('authors.edit', $author) }}" class="btn btn-secondary">Редактировать</a>
        <a href="{{ route('authors.index') }}" class="btn btn-secondary">Назад</a>
    </div>
</div>

@if($author->biography)
<div class="card">
    <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">Биография</h3>
    <p style="color: #334155;">{{ $author->biography }}</p>
</div>
@endif

<div class="card">
    <h2 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Книги автора в библиотеке</h2>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Жанр</th>
                    <th>Год</th>
                    <th>Количество</th>
                </tr>
            </thead>
            <tbody>
                @forelse($author->books as $book)
                    <tr>
                        <td><strong><a href="{{ route('books.show', $book) }}" style="color: var(--primary); text-decoration: none;">{{ $book->title }}</a></strong></td>
                        <td>{{ $book->genre ?? '—' }}</td>
                        <td>{{ $book->year ?? '—' }}</td>
                        <td>{{ $book->quantity }} шт.</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted);">Книги этого автора пока не внесены.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection