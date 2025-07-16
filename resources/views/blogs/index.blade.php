<!-- === TASK 2: blog verilerini tablo içine yazdırma === -->
@extends('layouts.app')

@section('title', 'Blog Listesi')

@section('content')
    <h2>Blog Listesi</h2>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <a href="{{ route('bloglar.create') }}">Yeni Blog Oluştur</a>

    <table id="bloglarTable" border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Başlık</th>
                <th>İçerik</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
                <tr>
                    <td>{{ $blog->id }}</td>
                    <td>{{ $blog->title }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($blog->content, 50) }}</td>
                    <td>
                    <!-- === TASK 3: blog crud işlemleri için linkler === -->
                        <a href="{{ route('bloglar.edit', $blog->id) }}">Düzenle</a>
                        <form action="{{ route('bloglar.destroy', $blog->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:red;">Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#bloglarTable').DataTable();
        });
    </script>
@endsection
