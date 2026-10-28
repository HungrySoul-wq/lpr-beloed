@extends('layouts.app')

@section('content')
    <h1>{{ $tour->title }}</h1>

    <dl class="row">
        <dt class="col-sm-3">Страна</dt>
        <dd class="col-sm-9">{{ $tour->country->name }}</dd>

        <dt class="col-sm-3">Дата начала</dt>
        <dd class="col-sm-9">{{ $tour->start_date->format('d.m.Y') }}</dd>

        <dt class="col-sm-3">Продолжительность</dt>
        <dd class="col-sm-9">{{ $tour->days }} дн.</dd>

        <dt class="col-sm-3">Цена</dt>
        <dd class="col-sm-9">{{ number_format((float) $tour->price, 2, ',', ' ') }} ₸</dd>

        <dt class="col-sm-3">Горящий тур</dt>
        <dd class="col-sm-9">{{ $tour->is_hot ? 'Да' : 'Нет' }}</dd>

        <dt class="col-sm-3">Виза требуется</dt>
        <dd class="col-sm-9">{{ $tour->country->visa_required ? 'Да' : 'Нет' }}</dd>
    </dl>

    <a href="{{ route('catalog.index') }}">&larr; К каталогу</a>
@endsection