@extends('layouts.app')

@section('title', $reader->full_name)

@section('content')
<div class="header-actions">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700;">{{ $reader->full_name }}</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Тел: {{ $reader->phone ?? '—' }} | Email: {{ $reader->email ?? '—' }}</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('readers.edit', $reader) }}" class="btn btn-secondary">Редактировать</a>
        <a href="{{ route('readers.index') }}" class="btn btn-secondary">Назад</a>
    </div>
</div>

<div class="card">
    <h2 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">История брака / выдачи книг читателю</h2>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Книга</th>
                    <th>Дата выдачи</th>
                    <th>План возврата</th>
                    <th>Фактический возврат</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reader->borrowings as $borrowing)
                    <tr>
                        <td><strong>{{ $borrowing->book->title ?? '—' }}</strong></td>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted);">Читатель ещё не брал книги.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection