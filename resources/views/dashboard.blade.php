@extends('layouts.app')

@section('title', 'Главная панель - ИС Библиотека')

@section('content')
<div class="header-actions">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700;">Панель управления библиотекой</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Сводная статистика и оперативный учет</p>
    </div>
    <div>
        <a href="{{ route('borrowings.create') }}" class="btn btn-primary">+ Выдать книгу</a>
    </div>
</div>

<div class="grid-stats">
    <div class="stat-card">
        <div class="num">{{ $booksCount }}</div>
        <div class="label">Всего наименований книг</div>
    </div>
    <div class="stat-card">
        <div class="num">{{ $authorsCount }}</div>
        <div class="label">Авторов в базе</div>
    </div>
    <div class="stat-card">
        <div class="num">{{ $readersCount }}</div>
        <div class="label">Зарегистрированных читателей</div>
    </div>
    <div class="stat-card">
        <div class="num" style="color: var(--warning);">{{ $borrowedCount }}</div>
        <div class="label">Книг на руках у читателей</div>
    </div>
    <div class="stat-card">
        <div class="num" style="color: var(--success);">{{ $returnedCount }}</div>
        <div class="label">Всего возвратов книг</div>
    </div>
</div>

<div class="card">
    <h2 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Последние выдачи книг</h2>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Книга</th>
                    <th>Читатель</th>
                    <th>Дата выдачи</th>
                    <th>Срок возврата</th>
                    <th>Статус</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestBorrowings as $borrowing)
                    <tr>
                        <td><strong>{{ $borrowing->book->title ?? 'Удалена' }}</strong></td>
                        <td>{{ $borrowing->reader->full_name ?? 'Удален' }}</td>
                        <td>{{ $borrowing->borrowed_at->format('d.m.Y') }}</td>
                        <td>{{ $borrowing->return_date ? $borrowing->return_date->format('d.m.Y') : '—' }}</td>
                        <td>
                            @if($borrowing->status === 'borrowed')
                                <span class="badge badge-warning">Выдана</span>
                            @else
                                <span class="badge badge-success">Возвращена ({{ $borrowing->returned_at->format('d.m.Y') }})</span>
                            @endif
                        </td>
                        <td>
                            @if($borrowing->status === 'borrowed')
                                <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success">Отметить возврат</button>
                                </form>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.75rem;">Завершено</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted);">Записи о выдаче книг отсутствуют.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection