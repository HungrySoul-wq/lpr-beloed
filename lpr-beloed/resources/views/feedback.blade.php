@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <form method="POST" action="{{ route('feedback.send') }}" class="col-md-6">
        @csrf
        <input type="text" name="name" class="form-control mb-2" placeholder="Имя">
        <textarea name="message" class="form-control mb-2" rows="3" placeholder="Сообщение"></textarea>
        <button class="btn btn-primary">Отправить</button>
    </form>
@endsection
