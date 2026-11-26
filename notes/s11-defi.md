# Session 11 - Défi

/mes-articles ne montre que mes articles, brouillons compris : oui
Un visiteur qui ouvre /mes-articles arrive sur /connexion : oui
Le cookie remember_web_ apparaît quand la case est cochée : oui
Les deux nouveaux tests passent et php artisan test est vert : oui

Pourquoi partir de $request->user()->posts() plutôt que de Post::where('user_id', $request->user()->id) ?
Partir de la relation $request->user()->posts() garantit que la requête est toujours bornée à l'utilisateur connecté en session, sans dépendre d'un identifiant passé manuellement ou exposé ailleurs.

Pourquoi la case remember ne doit-elle pas être dans le tableau passé à Auth::attempt() ?
Parce que Auth::attempt() utilise les clés du tableau comme critères de recherche (et le mot de passe) : passer 'remember' ferait chercher une colonne `remember` inexistante dans la table `users` et provoquerait une erreur SQL.