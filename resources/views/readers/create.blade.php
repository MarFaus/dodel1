@extends('layouts.app')

@section('title', 'Регистрация читателя')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h1 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem;">Регистрация читателя</h1>

    <form action="{{ route('readers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>ФИО читателя *</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Телефон</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="+7 700 000 00 00">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label>Дата рождения</label>
            <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control">
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Сохранить читателя</button>
            <a href="{{ route('readers.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection