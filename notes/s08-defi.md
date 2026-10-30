# Session 08 - Défi : pages et popularité par tag

La route `posts.tag` utilise `{tag:slug}` : oui
La page d'un tag n'affiche ni brouillon ni article d'un autre tag : oui
Les tags des cartes sont des liens : oui
L'accueil n'affiche que les tags qui ont au moins un article publié : oui
Les trois nouveaux tests passent et `php artisan test` est vert : oui

Pourquoi filtrer les tags vides après `get()` plutôt que d'afficher (0) ?

Un tag sans article publié mènerait à une page de résultats vide. Le filtrer évite de proposer ce lien inutile.

Combien de requêtes ajoute la liste des tags populaires, et pourquoi pas une par tag ?

Une requête charge la liste des tags. `withCount()` calcule le nombre d'articles publiés dans cette même requête avec une sous-requête SQL ; il n'y a pas de requête par tag. Le filtrage après `get()` se fait sur la collection en mémoire.

Pourquoi aucune migration, aucun modèle et aucun test PostgreSQL spécifique n'a changé ?

Le bonus PostgreSQL ne nécessite pas de changement de schéma ni de modèle : Eloquent et le constructeur de schéma traduisent les opérations pour le pilote configuré. Le code n'utilise pas de SQL brut spécifique à SQLite. Les tests fonctionnels du défi ont été ajoutés, mais ils utilisent la base SQLite en mémoire configurée pour les tests ; aucun test PostgreSQL spécifique n'est nécessaire.
