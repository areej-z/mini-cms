# Session 03 - Routes, contrôleurs et layout

## Défi

URL produite par route('about') :
http://localhost:8000/a-propos

URL produite par route('posts.show', 'routes-et-controleurs') :
http://localhost:8000/posts/routes-et-controleurs

URL produite par route('posts.archive', 2025) :
http://localhost:8000/posts/archive/2025

Pourquoi /posts/archive/abc et /posts/article-inconnu répondent toutes deux 404, et quelle ligne de code en est responsable dans chaque cas ?
/posts/archive/abc : la contrainte whereNumber('year') dans routes/web.php rejette la route avant d'atteindre le contrôleur.
/posts/article-inconnu : la route correspond à l'expression régulière, mais l'article n'existe pas dans le tableau, ce qui déclenche abort(404) dans la méthode show() du PostController.

Que se passe-t-il si une vue appelle route('posts.show') sans paramètre ?
Laravel lève une exception de type Missing required parameter for [Route: posts.show].