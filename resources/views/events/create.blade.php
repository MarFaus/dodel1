@extends('layouts.app')

@section('title', 'Создание мероприятия')

@section('content')
    <h1>Создание мероприятия</h1>

    @if($errors->any())
        <div class="alert-error">
            <strong>Проверьте введенные данные:</strong>
            <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('events.store') }}">
        @csrf

        <div class="form-group">
            <label for="name">Название мероприятия *</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="event_date">Дата проведения *</label>
            <input 
                type="date" 
                id="event_date" 
                name="event_date" 
                value="{{ old('event_date') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="price">Цена (₸) *</label>
            <input 
                type="number" 
                id="price" 
                name="price" 
                step="0.01" 
                value="{{ old('price') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea 
                id="description" 
                name="description" 
                rows="4"
            >{{ old('description') }}</textarea>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn">Сохранить</button>
            <a href="{{ route('events.index') }}" class="btn" style="background-color: #64748b;">Отмена</a>
        </div>
    </form>
@endsection