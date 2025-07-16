<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Listeleme
    public function index()
    {// === TASK 2: blog listeleme ===
        $blogs = Blog::all();
        return view('blogs.index', compact('blogs'));
    }

    // === TASK 3: blog crud işlemleri  ===
    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Blog::create($request->only('title', 'content'));

        return redirect()->route('bloglar.index')->with('success', 'Blog başarıyla oluşturuldu.');
    }

    public function edit(Blog $blog)
    {
        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $blog->update($request->only('title', 'content'));

        return redirect()->route('bloglar.index')->with('success', 'Blog başarıyla güncellendi.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('bloglar.index')->with('success', 'Blog başarıyla silindi.');
    }
}
