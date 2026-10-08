# Cycle de vie d'une requête vers /heure

1. **Le navigateur** envoie une requête GET vers `/heure`.
2. **`public/index.php`** (le point d'entrée) charge l'autoloader Composer et initialise l'application via `bootstrap/app.php`.
3. **Le routeur** trouve la route `/heure` dans **`routes/web.php`** et exécute sa closure.
4. **La vue** **`resources/views/heure.blade.php`** est appelée et compilée en HTML.
5. **Laravel** renvoie la réponse finale au navigateur.