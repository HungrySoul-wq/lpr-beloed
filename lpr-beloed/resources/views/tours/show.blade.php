@extends('layouts.app')

@section('content')
    <h1>{{ $tour->title }}</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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

        <dt class="col-sm-3">Дополнительные услуги</dt>
        <dd class="col-sm-9">
            @forelse ($tour->extras as $extra)
                <span class="badge bg-secondary">{{ $extra->name }}</span>
            @empty
                Не указаны
            @endforelse
        </dd>
    </dl>

    <a href="{{ route('tours.edit', $tour) }}" class="btn btn-warning">Изменить</a>
    <a href="{{ route('tours.index') }}" class="btn btn-secondary">К списку туров</a>
@endsection