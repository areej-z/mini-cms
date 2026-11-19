# Session 09 - Défi

Le bandeau s'affiche sur toutes les pages quand SITE_READ_ONLY=true : oui
Le bandeau disparaît quand SITE_READ_ONLY=false : oui
La page Article introuvable propose au plus trois articles publiés, sans brouillon : oui
Aucune LazyLoadingViolationException sur /posts/999 : oui
Les deux nouveaux tests passent et php artisan test est vert : oui

Pourquoi le bandeau est-il dans le layout et pas dans chaque vue ?
Le layout entoure toutes les pages (y compris les vues d'erreur) : un seul bloc suffit pour tout le site et toute modification se fait à un seul endroit.

Pourquoi le test du bandeau n'a-t-il pas besoin de modifier .env ?
`config(['site.read_only' => true])` modifie la configuration uniquement en mémoire pour le test courant ; `phpunit.xml` conserve `false` pour les autres tests et `.env` reste intact.