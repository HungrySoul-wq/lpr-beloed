@extends('layouts.app')

@section('content')
    <h1>{{ $tour['title'] }}</h1>

    <dl class="row">
        <dt class="col-sm-3">Код</dt>         <dd class="col-sm-9">{{ $tour['code'] }}</dd>
        <dt class="col-sm-3">Страна</dt>      <dd class="col-sm-9">{{ $tour['country'] }}</dd>
        <dt class="col-sm-3">Дата начала</dt> <dd class="col-sm-9">{{ \Carbon\Carbon::parse($tour['start_date'])->format('d.m.Y') }}</dd>
        <dt class="col-sm-3">Дней</dt>        <dd class="col-sm-9">{{ $tour['days'] }}</dd>
        <dt class="col-sm-3">Цена</dt>
        <dd class="col-sm-9">{{ number_format($tour['price'], 2, ',', ' ') }} ₸</dd>
        <dt class="col-sm-3">Горящий</dt>     <dd class="col-sm-9">{{ $tour['is_hot'] ? 'Да' : 'Нет' }}</dd>
    </dl>

    <a href="{{ route('catalog.index') }}">&larr; К каталогу</a>
@endsection
