<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - Mini-CMS</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 40rem; margin: 3rem auto; padding: 0 1rem; color: #1f2937; line-height: 1.6; }
        h1 { color: #e6291b; }
    </style>
</head>
<body>
    <h1>À propos de Mini-CMS</h1>
    <p>Mini-CMS est le projet fil rouge de l'Atelier Framework Côté Serveur (Laravel 13).</p>
    <p>Auteur : {{ $auteur }}</p>
    <p>Groupe : {{ $groupe }}</p>
    <p>
        <a href="/">Accueil</a> |
        <a href="/bienvenue">Bienvenue</a> |
        <a href="/heure">Heure</a>
    </p>
</body>
</html>