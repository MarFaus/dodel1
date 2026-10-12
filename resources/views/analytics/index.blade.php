@extends('layouts.app')
@section('content')
<section style="padding-block: 40px;">
    <h1 style="font-family: var(--display); font-size: 28px; font-weight: 200;">📊 Аналитика продаж</h1>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 24px;">
        <div style="background: var(--surface); padding: 20px; border-radius: 8px; border: 1px solid var(--line);">
            <span style="font-size: 11px; color: var(--dim); text-transform: uppercase;">Выручка</span>
            <b style="display: block; font-family: var(--display); font-size: 24px; color: var(--gold); margin-top: 6px;">2 450 000 ₸</b>
        </div>
        <div style="background: var(--surface); padding: 20px; border-radius: 8px; border: 1px solid var(--line);">
            <span style="font-size: 11px; color: var(--dim); text-transform: uppercase;">Заполняемость</span>
            <b style="display: block; font-family: var(--display); font-size: 24px; color: var(--ok); margin-top: 6px;">78%</b>
        </div>
    </div>
</section>
@endsection