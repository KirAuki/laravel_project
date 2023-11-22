<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index()
    {
        // Путь к JSON-файлу с данными
        $jsonPath = public_path('articles.json');

        $data = json_decode(File::get($jsonPath), true);
        

        return view('gallery', compact('data'));
    }
}