@extends('layouts.app')

@section('title', 'Книги - ИС Библиотека')

@section('content')
<div class="header-actions">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700;">Каталог книг</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Управление реестром книг</p>
    </div>
    <a href="{{ route('books.create') }}" class="btn btn-primary">+ Добавить книгу</a>
</div>

<div class="card">
    <form method="GET" action="{{ route('books.index') }}" class="form-row" style="margin-bottom: 1rem;">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Поиск по названию, ISBN...">
        </div>
        <div>
            <select name="author_id" class="form-control">
                <option value="">Все авторы</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ request('author_id') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="genre" class="form-control">
                <option value="">Все жанры</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                @endforeach
            </select>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-secondary" style="flex: 1;">Найти</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Сброс</a>
        </div>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Автор</th>
                    <th>Жанр</th>
                    <th>Год</th>
                    <th>Экземпляры</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td><strong><a href="{{ route('books.show', $book) }}" style="color: var(--primary); text-decoration: none;">{{ $book->title }}</a></strong></td>
                        <td>{{ $book->author->name ?? '—' }}</td>
                        <td>{{ $book->genre ?? '—' }}</td>
                        <td>{{ $book->year ?? '—' }}</td>
                        <td>{{ $book->available_quantity }} / {{ $book->quantity }}</td>
                        <td>
                            @if($book->available && $book->available_quantity > 0)
                                <span class="badge badge-success">Доступна</span>
                            @else
                                <span class="badge badge-warning">Занята / Недоступна</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-secondary">Просмотр</a>
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-secondary">Ред.</a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline;" onsubmit="return confirm('Удалить книгу?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">X</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted);">Книги не найдены.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1rem;">
        {{ $books->links() }}
    </div>
</div>
@endsection