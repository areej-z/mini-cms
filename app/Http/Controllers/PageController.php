<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'latestPosts' => Post::published()
                ->with('user', 'category', 'tags')
                ->latest('published_at')
                ->take(3)
                ->get(),
            'categories' => Category::withCount([
                'posts' => fn (Builder $query) => $query->published(),
            ])
                ->orderBy('name')
                ->get(),
            'tags' => Tag::withCount([
                'posts' => fn (Builder $query) => $query->published(),
            ])
                ->orderByDesc('posts_count')
                ->orderBy('name')
                ->get()
                ->filter(fn (Tag $tag) => $tag->posts_count > 0),
        ]);
    }

    public function about(): View
    {
        return view('a-propos', [
            'auteur' => 'Arij Znagui',
            'groupe' => 'MDW32',
        ]);
    }

    public function time(): View
    {
        return view('heure', [
            'heure' => now()->format('H:i'),
            'date' => now()->format('d/m/Y'),
        ]);
    }
}
