@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <form method="POST" class="col-lg-8"
          action="{{ $tour->exists ? route('tours.update', $tour) : route('tours.store') }}">
        @csrf
        @if ($tour->exists) @method('PUT') @endif

        <label for="country_id" class="form-label">Страна</label>
        <select id="country_id" name="country_id"
                class="form-select mb-2 @error('country_id') is-invalid @enderror">
            <option value="">Выберите страну</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" @selected(old('country_id', $tour->country_id) == $country->id)>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
        @error('country_id') <div class="invalid-feedback d-block mb-2">{{ $message }}</div> @enderror

        <label for="title" class="form-label mt-2">Название тура</label>
        <input id="title" name="title" type="text" value="{{ old('title', $tour->title) }}"
               class="form-control @error('title') is-invalid @enderror">
        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <label for="start_date" class="form-label mt-2">Дата начала</label>
        <input id="start_date" name="start_date" type="date"
               value="{{ old('start_date', $tour->start_date?->format('Y-m-d')) }}"
               class="form-control @error('start_date') is-invalid @enderror">
        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <label for="days" class="form-label mt-2">Количество дней</label>
        <input id="days" name="days" type="number" value="{{ old('days', $tour->days) }}"
               class="form-control @error('days') is-invalid @enderror">
        @error('days') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <label for="price" class="form-label mt-2">Цена (₸)</label>
        <input id="price" name="price" type="text" value="{{ old('price', $tour->price) }}"
               class="form-control @error('price') is-invalid @enderror">
        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <label for="description" class="form-label mt-2">Описание</label>
        <textarea id="description" name="description" rows="3"
                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $tour->description) }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <div class="form-check my-3">
            <input id="is_hot" name="is_hot" type="checkbox" value="1" class="form-check-input"
                   @checked(old('is_hot', $tour->is_hot))>
            <label for="is_hot" class="form-check-label">Горящий тур</label>
        </div>

        <button class="btn btn-primary">Сохранить</button>
        <a href="{{ route('tours.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
@endsection
