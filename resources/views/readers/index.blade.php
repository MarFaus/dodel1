@extends('layouts.app')

@section('title', 'Читатели - ИС Библиотека')

@section('content')
<div class="header-actions">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700;">База читателей</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Зарегистрированные посетители библиотеки</p>
    </div>
    <a href="{{ route('readers.create') }}" class="btn btn-primary">+ Зарегистрировать читателя</a>
</div>

<div class="card">
    <form method="GET" action="{{ route('readers.index') }}" style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Поиск по ФИО, телефону, email...">
        <button type="submit" class="btn btn-secondary">Найти</button>
        <a href="{{ route('readers.index') }}" class="btn btn-secondary">Сбросить</a>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ФИО Читателя</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th>Дата рождения</th>
                    <th>Выдач за всё время</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($readers as $reader)
                    <tr>
                        <td><strong><a href="{{ route('readers.show', $reader) }}" style="color: var(--primary); text-decoration: none;">{{ $reader->full_name }}</a></strong></td>
                        <td>{{ $reader->phone ?? '—' }}</td>
                        <td>{{ $reader->email ?? '—' }}</td>
                        <td>{{ $reader->birth_date ? $reader->birth_date->format('d.m.Y') : '—' }}</td>
                        <td><span class="badge badge-secondary">{{ $reader->borrowings_count }}</span></td>
                        <td>
                            <a href="{{ route('readers.show', $reader) }}" class="btn btn-sm btn-secondary">Карточка</a>
                            <a href="{{ route('readers.edit', $reader) }}" class="btn btn-sm btn-secondary">Ред.</a>
                            <form action="{{ route('readers.destroy', $reader) }}" method="POST" style="display:inline;" onsubmit="return confirm('Удалить читателя?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">X</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted);">Читатели не найдены.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1rem;">
        {{ $readers->links() }}
    </div>
</div>
@endsection