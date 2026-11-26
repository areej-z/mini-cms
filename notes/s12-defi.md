# Session 12 - Défi

1. Pourquoi role n'est-il pas dans #[Fillable], et comment votre contrôleur le modifie-t-il quand même ?
Garder `role` hors de `$fillable` protège contre l'assignation de masse : même si une requête d'inscription ou de profil contient un champ `role`, `create()` ou `update()` l'ignore. Le contrôleur de gestion des rôles affecte l'attribut directement (`$user->role = $request->validated('role')`) après vérification de la Policy et validation, puis appelle `$user->save()`.

2. Pourquoi le callback de Gate::before doit-il renvoyer null, et non false, pour un auteur ?
Renvoyer `false` dans `Gate::before` est un refus définitif qui court-circuite toutes les Gates et Policies suivantes : un auteur ne pourrait même plus modifier ses propres articles. Renvoyer `null` indique que `Gate::before` ne tranche pas ce cas et laisse Laravel évaluer la Gate ou la méthode de Policy concernée.
