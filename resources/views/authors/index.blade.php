@extends('layouts.app')

@section('title', 'Авторы - ИС Библиотека')

@section('content')
<div class="header-actions">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700;">Справочник авторов</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Список авторов книг</p>
    </div>
    <a href="{{ route('authors.create') }}" class="btn btn-primary">+ Добавить автора</a>
</div>

<div class="card">
    <form method="GET" action="{{ route('authors.index') }}" style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Поиск по имени или стране...">
        <button type="submit" class="btn btn-secondary">Найти</button>
        <a href="{{ route('authors.index') }}" class="btn btn-secondary">Сбросить</a>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ФИО / Имя</th>
                    <th>Страна</th>
                    <th>Дата рождения</th>
                    <th>Книг в базе</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($authors as $author)
                    <tr>
                        <td><strong><a href="{{ route('authors.show', $author) }}" style="color: var(--primary); text-decoration: none;">{{ $author->name }}</a></strong></td>
                        <td>{{ $author->country ?? '—' }}</td>
                        <td>{{ $author->birth_date ? $author->birth_date->format('d.m.Y') : '—' }}</td>
                        <td><span class="badge badge-secondary">{{ $author->books_count }}</span></td>
                        <td>
                            <a href="{{ route('authors.show', $author) }}" class="btn btn-sm btn-secondary">Книги</a>
                            <a href="{{ route('authors.edit', $author) }}" class="btn btn-sm btn-secondary">Ред.</a>
                            <form action="{{ route('authors.destroy', $author) }}" method="POST" style="display:inline;" onsubmit="return confirm('Удалить автора?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">X</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted);">Авторы не найдены.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1rem;">
        {{ $authors->links() }}
    </div>
</div>
@endsection