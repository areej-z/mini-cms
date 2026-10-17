<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'latestPosts' => Post::published()
                ->latest('published_at')
                ->take(3)
                ->get(),
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