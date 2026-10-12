@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="header-actions">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700;">{{ $book->title }}</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Автор: {{ $book->author->name ?? '—' }}</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('books.edit', $book) }}" class="btn btn-secondary">Редактировать</a>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Назад к списку</a>
    </div>
</div>

<div class="card">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        <div><strong>Жанр:</strong> {{ $book->genre ?? '—' }}</div>
        <div><strong>Год издания:</strong> {{ $book->year ?? '—' }}</div>
        <div><strong>ISBN:</strong> {{ $book->isbn ?? '—' }}</div>
        <div><strong>Всего в наличии:</strong> {{ $book->quantity }} шт.</div>
        <div><strong>Доступно для выдачи:</strong> {{ $book->available_quantity }} шт.</div>
    </div>
    @if($book->description)
        <div style="border-top: 1px solid var(--border); padding-top: 1rem;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">Описание</h3>
            <p style="color: #334155;">{{ $book->description }}</p>
        </div>
    @endif
</div>

<div class="card">
    <h2 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">История выдачи этой книги</h2>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Читатель</th>
                    <th>Дата выдачи</th>
                    <th>План возврата</th>
                    <th>Фактический возврат</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                @forelse($book->borrowings as $borrowing)
                    <tr>
                        <td>{{ $borrowing->reader->full_name ?? '—' }}</td>
                        <td>{{ $borrowing->borrowed_at->format('d.m.Y') }}</td>
                        <td>{{ $borrowing->return_date ? $borrowing->return_date->format('d.m.Y') : '—' }}</td>
                        <td>{{ $borrowing->returned_at ? $borrowing->returned_at->format('d.m.Y') : '—' }}</td>
                        <td>
                            @if($borrowing->status === 'borrowed')
                                <span class="badge badge-warning">Выдана</span>
                            @else
                                <span class="badge badge-success">Возвращена</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted);">Книга ещё никому не выдавалась.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection