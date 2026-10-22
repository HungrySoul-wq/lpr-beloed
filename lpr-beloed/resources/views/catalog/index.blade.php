@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <form method="GET" action="{{ route('catalog.index') }}" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Название...">
        </div>
        <div class="col-auto">
            <select name="sort" class="form-select">
                <option value="title" @selected($sort === 'title')>По названию</option>
                <option value="start_date" @selected($sort === 'start_date')>По дате начала</option>
                <option value="price" @selected($sort === 'price')>По цене</option>
            </select>
        </div>
        <div class="col-auto"><button class="btn btn-secondary">Найти</button></div>
    </form>

    <table class="table">
        <tr><th>№</th><th>Название</th><th>Страна</th><th>Дата начала</th><th>Дней</th><th></th></tr>
        @forelse ($tours as $tour)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><a href="{{ route('catalog.show', ['id' => $tour['id']]) }}">{{ $tour['title'] }}</a></td>
                <td><a href="{{ route('catalog.country', $tour['country']) }}">{{ $tour['country'] }}</a></td>
                <td>{{ \Carbon\Carbon::parse($tour['start_date'])->format('d.m.Y') }}</td>
                <td>{{ $tour['days'] }}</td>
                <td>@if ($tour['is_hot']) <span class="badge bg-danger">Горящий</span> @endif</td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-muted">Ничего не найдено.</td></tr>
        @endforelse
    </table>
@endsection
