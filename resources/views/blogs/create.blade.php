<!-- === TASK 3: blog oluşturma formu === -->

@extends('layouts.app')

@section('title', 'Yeni Blog Oluştur')

@section('content')
    <h2>Yeni Blog Oluştur</h2>

    @if($errors->any())
        <ul style="color:red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('bloglar.store') }}" method="POST">
        @csrf
        <label>Başlık:</label><br>
        <input type="text" name="title" value="{{ old('title') }}"><br><br>

        <label>İçerik:</label><br>
        <textarea name="content" rows="5">{{ old('content') }}</textarea><br><br>

        <button type="submit">Kaydet</button>
    </form>

    <a href="{{ route('bloglar.index') }}">Geri Dön</a>
@endsection
