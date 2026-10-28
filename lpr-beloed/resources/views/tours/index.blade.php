@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Управление турами</h1>
        <a href="{{ route('tours.create') }}" class="btn btn-primary">Добавить тур</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Название</th>
                <th>Страна</th>
                <th>Дата начала</th>
                <th>Дней</th>
                <th>Цена</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tours as $tour)
                <tr>
                    <td>{{ $tour->title }}</td>
                    <td>{{ $tour->country->name }}</td>
                    <td>{{ $tour->start_date->format('d.m.Y') }}</td>
                    <td>{{ $tour->days }}</td>
                    <td>{{ number_format((float) $tour->price, 2, ',', ' ') }} ₸</td>
                    <td class="text-nowrap">
                        <a href="{{ route('tours.show', $tour) }}" class="btn btn-sm btn-info">Открыть</a>
                        <a href="{{ route('tours.edit', $tour) }}" class="btn btn-sm btn-warning">Изменить</a>
                        <form action="{{ route('tours.destroy', $tour) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Удалить этот тур?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Туры не найдены.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $tours->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>

    <a href="{{ route('catalog.index') }}">← Вернуться в каталог</a>
@endsection