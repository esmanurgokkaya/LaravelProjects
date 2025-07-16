<?php

namespace App\Http\Controllers;

class AnasayfaController extends Controller
{
    public function index()
    { //view döndüren controller
        return view('anasayfa');
    }
}
