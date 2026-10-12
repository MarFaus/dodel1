@extends('layouts.app')

@section('title', 'Выдача книг')

@section('content')
<div class="header-actions">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700;">Журнал выдачи книг</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Контроль и учет возврата книг</p>
    </div>
    <a href="{{ route('borrowings.create') }}" class="btn btn-primary">+ Выдать книгу</a>
</div>

<div class="card">
    <form method="GET" action="{{ route('borrowings.index') }}" style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
        <select name="status" class="form-control" style="max-width: 200px;">
            <option value="">Все статусы</option>
            <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>На руках (Выдана)</option>
            <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Возвращена</option>
        </select>
        <button type="submit" class="btn btn-secondary">Фильтровать</button>
        <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">Сброс</a>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Книга</th>
                    <th>Читатель</th>
                    <th>Дата выдачи</th>
                    <th>Плановый возврат</th>
                    <th>Фактический возврат</th>
                    <th>Статус</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $borrowing)
                    <tr>
                        <td><strong>{{ $borrowing->book->title ?? '—' }}</strong></td>
                        <td>{{ $borrowing->reader->full_name ?? '—' }}</td>
                        <td>{{ $borrowing->borrowed_at->format('d.m.Y') }}</td>
                        <td>{{ $borrowing->return_date ? $borrowing->return_date->format('d.m.Y') : '—' }}</td>
                        <td>{{ $borrowing->returned_at ? $borrowing->returned_at->format('d.m.Y') : '—' }}</td>
                        <td>
                            @if($borrowing->status === 'borrowed')
                                <span class="badge badge-warning">На руках</span>
                            @else
                                <span class="badge badge-success">Возвращена</span>
                            @endif
                        </td>
                        <td>
                            @if($borrowing->status === 'borrowed')
                                <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-success">Вернуть</button>
                                </form>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.75rem;">Завершено</span>
                            @endif
                            <form action="{{ route('borrowings.destroy', $borrowing) }}" method="POST" style="display:inline;" onsubmit="return confirm('Удалить запись?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">X</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted);">Записи о выдаче книг не найдены.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1rem;">
        {{ $borrowings->links() }}
    </div>
</div>
@endsection