@extends('layouts.app')

@section('content')
    <h1>Редактировать тур</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tours.update', $tour) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Название тура</label>
            <input id="title" name="title" type="text" maxlength="150"
                   class="form-control" value="{{ old('title', $tour->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="country_id" class="form-label">Страна</label>
            <select id="country_id" name="country_id" class="form-select" required>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}"
                        @selected(old('country_id', $tour->country_id) == $country->id)>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Дата начала</label>
            <input id="start_date" name="start_date" type="date"
                   class="form-control"
                   value="{{ old('start_date', $tour->start_date->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="days" class="form-label">Количество дней</label>
            <input id="days" name="days" type="number" min="1" max="365"
                   class="form-control" value="{{ old('days', $tour->days) }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Цена (₸)</label>
            <input id="price" name="price" type="number" min="0" max="99999999.99"
                   step="0.01" class="form-control"
                   value="{{ old('price', $tour->price) }}" required>
        </div>

        <div class="form-check mb-3">
            <input id="is_hot" name="is_hot" type="checkbox" value="1"
                   class="form-check-input"
                   @checked(old('is_hot', $tour->is_hot))>
            <label for="is_hot" class="form-check-label">Горящий тур</label>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="{{ route('tours.show', $tour) }}" class="btn btn-secondary">Отмена</a>
    </form>
@endsection