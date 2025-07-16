<!-- === TASK 3: blog düzenleme formu === -->
@extends('layouts.app')

@section('title', 'Blog Düzenle')

@section('content')
    <h2>Blog Düzenle</h2>

    @if($errors->any())
        <ul style="color:red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('bloglar.update', $blog->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Başlık:</label><br>
        <input type="text" name="title" value="{{ old('title', $blog->title) }}"><br><br>

        <label>İçerik:</label><br>
        <textarea name="content" rows="5">{{ old('content', $blog->content) }}</textarea><br><br>

        <button type="submit">Güncelle</button>
    </form>

    <a href="{{ route('bloglar.index') }}">Geri Dön</a>
@endsection
