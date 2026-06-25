<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        return view('admin.themes.index', compact('themes'));
    }

    public function create()
    {
        return view('admin.themes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'icone' => 'required|string|max:10',
            'description' => 'required|string',
        ]);

        Theme::create([
            'nom' => $request->nom,
            'slug' => Str::slug($request->nom),
            'icone' => $request->icone,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.themes.index')->with('success', 'Thème ajouté !');
    }

    public function edit(Theme $theme)
    {
        return view('admin.themes.edit', compact('theme'));
    }

    public function update(Request $request, Theme $theme)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'icone' => 'required|string|max:10',
            'description' => 'required|string',
        ]);

        $theme->update([
            'nom' => $request->nom,
            'slug' => Str::slug($request->nom),
            'icone' => $request->icone,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.themes.index')->with('success', 'Thème modifié !');
    }

    public function destroy(Theme $theme)
    {
        $theme->delete();
        return redirect()->route('admin.themes.index')->with('success', 'Thème supprimé !');
    }
}
