<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;

class HomeController extends Controller
{
    public function index()
    {
        $themes = Theme::select('nom', 'description', 'slug', 'icone')->get();

        return view('home', compact('themes'));
    }
}
