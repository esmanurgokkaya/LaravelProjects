<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# Laravel 12 Blog Projesi – Görev Bazlı Uygulama

Bu proje, Laravel 12 kullanılarak hazırlanmış bir blog uygulamasıdır. Aşağıda adım adım görevler (`TASK`) ve kod örnekleri ile birlikte anlatılmıştır.

---

## ✅ TASK 1 – Laravel Kurulumu ve View Gösterimi


* Laravel kurulumu
* Controller → View yönlendirmesi
* Layout sistemi

---

###   Laravel 12 Kurulumu

```bash
composer create-project laravel/laravel blog-proje
cd blog-proje
php artisan serve
```

### Layout Oluşturma

**resources/views/layouts/app.blade.php**

```blade
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Görev Projesi</title>
</head>
<body>
    <header><h2>Üst Menü / Layout Alanı</h2></header>

    <main>
        @yield('content')
    </main>

    <footer><small>Alt Bilgi</small></footer>
</body>
</html>
```
###  View Oluşturma

**resources/views/anasayfa.blade.php**

```blade
@extends('layouts.app')

@section('content')
    <h1>Bu Anasayfa</h1>
@endsection
```

###  Controller Oluşturma

**app/Http/Controllers/AnasayfaController.php**

```php
<?php

namespace App\Http\Controllers;

class AnasayfaController extends Controller
{
    public function index()
    {
        return view('anasayfa');
    }
}
```

###  Route Oluşturma

**routes/web.php**

```php
use App\Http\Controllers\AnasayfaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AnasayfaController::class, 'index'])->name('anasayfa');
```

---

## ✅ TASK 2 – Blog Modeli ve Blogları Listeleme
Bu görevde Blog isminde bir model ve migration dosyası oluşturduk. Veritabanından tüm blogları çekerek view dosyasına blog::all() ile aktardık. View içerisinde verileri @foreach ile tablo halinde listeledik.
###  Migration

**database/migrations/2025_07_15_123538_create_blogs_table.php**

```php
Schema::create('blogs', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->timestamps();
});
```

###  Seeder

**database/seeders/BlogSeeder.php**

```php
class BlogSeeder extends Seeder
{
    public function run()
    {
        Blog::create([
            'title' => 'İlk Blog Yazısı',
            'content' => 'Bu içerik seed ile eklendi.'
        ]);
    }
}
```

###  Controller

**app/Http/Controllers/BlogController.php**

```php
public function index()
{
    $blogs = Blog::all();
    return view('blogs.index', compact('blogs'));
}
```

### View

**resources/views/blogs/index.blade.php** 

```php
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

```

### Route

```php
Route::resource('bloglar', BlogController::class)->parameters([
    'bloglar' => 'blog'
]);
```

---

##  ✅ TASK 3 – CRUD + Oturum (Breeze)
Bu adımda blog için:
Oturum işlemleri,
Oluşturma (create),
Listeleme (index + datatable),
Güncelleme (edit),
Silme (delete)
fonksiyonlarını yazdık. Tüm işlemler için gerekli view dosyaları ve formlar hazırlandı.

###  Breeze Kurulumu

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run dev
php artisan migrate
```

### View Dosyaları

* **create.blade.php**: Blog oluşturma formu
[create blog view kodları](https://github.com/esmanurgokkaya/LaravelProjects/blob/main/resources/views/blogs/create.blade.php "create blog view kodları")

* **edit.blade.php**: Blog düzenleme formu
[edit blog view kodları](https://github.com/esmanurgokkaya/LaravelProjects/blob/main/resources/views/blogs/edit.blade.php "edit view kodları")

* **index.blade.php**: Listeleme + düzenle/sil butonları
[index blog view kodları](https://github.com/esmanurgokkaya/LaravelProjects/blob/main/resources/views/blogs/index.blade.php "index view kodları")

\[Tüm kodlar yukarıdaki linklerde detaylı olarak bulunmaktadır.]

### Controller CRUD Metotları

* `create()`
* `store()`
* `edit()`
* `update()`
* `destroy()`

[blog contoller kodları](https://github.com/esmanurgokkaya/LaravelProjects/blob/main/app/Http/Controllers/BlogController.php "blog contoller kodları")

\[Tüm kodlar yukarıdaki linkte detaylı olarak bulunmaktadır.]
###  Route - Auth ile Koruma

**routes/web.php**

```php
Route::middleware(['auth'])->group(function () {
    Route::resource('bloglar', BlogController::class)->parameters([
        'bloglar' => 'blog'
    ]);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
```

---
