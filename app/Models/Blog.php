<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{ // blog model 
    // title ve content alanları tutulur
    protected $fillable = ['title', 'content'];
}
