<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminGenreController extends Controller
{
    public function index()
    {
        $genres = Genre::query()
            ->orderBy('name')
            ->paginate(30);

        return view('admin.genres.index', [
            'genres' => $genres,
        ]);
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:genres,name'],
            'slug' => ['nullable', 'string', 'max:100', 'unique:genres,slug'],
        ]);

        $baseSlug = $validated['slug'] !== null && $validated['slug'] !== ''
            ? $validated['slug']
            : Str::slug($validated['name']);

        $slug = $baseSlug;
        $i = 2;
        while (Genre::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$i;
            $i++;
        }

        $genre = Genre::create([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.genres.edit', $genre)
            ->with('status', 'Жанрът е създаден.');
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', [
            'genre' => $genre,
        ]);
    }

    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:genres,name,'.$genre->id],
            'slug' => ['required', 'string', 'max:100', 'unique:genres,slug,'.$genre->id],
        ]);

        $genre->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
        ]);

        return back()->with('status', 'Жанрът е обновен.');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()
            ->route('admin.genres.index')
            ->with('status', 'Жанрът е изтрит.');
    }
}

