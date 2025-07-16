<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run()
    {// === TASK 2: Blog seeder ===
        Blog::create([
            'title' => 'İlk Blog Yazısı',
            'content' => 'Bu içerik seed ile eklendi.'
        ]);
    }
}
