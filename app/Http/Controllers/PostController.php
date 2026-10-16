<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
    private function posts(): array
    {
        return [
            'bienvenue-sur-mini-cms' => [
                'slug' => 'bienvenue-sur-mini-cms',
                'title' => 'Bienvenue sur Mini-CMS',
                'excerpt' => "Présentation du projet fil rouge de l'atelier et de ses objectifs.",
                'author' => 'Équipe Mini-CMS',
                'date' => '01/10/2026',
                'year' => 2026,
                'featured' => true,
                'body' => [
                    "Mini-CMS est la petite plateforme de publication que vous construisez tout au long de l'atelier.",
                    "Chaque semaine, une nouvelle fonctionnalité s'ajoute au même projet, de la page d'accueil jusqu'à l'API.",
                ],
            ],
            'comprendre-le-routage' => [
                'slug' => 'comprendre-le-routage',
                'title' => 'Comprendre le routage Laravel',
                'excerpt' => "Comment une URL arrive jusqu'à un contrôleur et une vue.",
                'author' => 'Équipe Mini-CMS',
                'date' => '03/10/2026',
                'year' => 2026,
                'featured' => false,
                'body' => [
                    "Une route associe une URL à une action. Donner un nom à la route permet de générer le lien avec route().",
                    "Les paramètres, comme le slug d'un article, sont transmis automatiquement à la méthode du contrôleur.",
                ],
            ],
            'les-composants-blade' => [
                'slug' => 'les-composants-blade',
                'title' => 'Les composants Blade',
                'excerpt' => "Écrire une fois, réutiliser partout : la navigation, les cartes et les alertes.",
                'author' => 'Équipe Mini-CMS',
                'date' => '06/10/2026',
                'year' => 2026,
                'featured' => false,
                'body' => [
                    "Un composant anonyme est un simple fichier Blade placé dans le dossier components.",
                    "Il reçoit des propriétés avec @props et du contenu avec le slot, ce qui évite de recopier le même HTML.",
                ],
            ],
            'preparer-la-suite' => [
                'slug' => 'preparer-la-suite',
                'title' => 'Préparer la suite du projet',
                'excerpt' => "Les articles sont encore dans un tableau PHP : voici ce qui arrive ensuite.",
                'author' => 'Équipe Mini-CMS',
                'date' => '08/10/2026',
                'year' => 2026,
                'featured' => false,
                'body' => [
                    "Pour l'instant, les articles vivent dans un tableau écrit dans le contrôleur.",
                    "Dans la prochaine session, ils seront enregistrés dans une base de données.",
                ],
            ],
        ];
    }

    public function index()
    {
        return view('posts.index', [
            'heading' => 'Tous les articles',
            'posts' => $this->posts(),
        ]);
    }

    public function archive(string $year)
    {
        $posts = array_filter(
            $this->posts(),
            fn (array $post) => $post['year'] === (int) $year
        );

        return view('posts.index', [
            'heading' => 'Articles de '.$year,
            'posts' => $posts,
        ]);
    }

    public function show(string $slug)
    {
        $posts = $this->posts();

        if (! array_key_exists($slug, $posts)) {
            abort(404);
        }

        return view('posts.show', [
            'post' => $posts[$slug],
        ]);
    }
}