# Session 06 - Défi : publier et dépublier

La route posts.publication apparaît dans route:list avec le verbe PATCH : oui
Le bouton affiche « Publier » sur un brouillon et « Dépublier » sur un article publié : oui
published_at est rempli à la publication et vidé à la dépublication : oui
Le nouveau test passe et php artisan test est vert : oui

Pourquoi PATCH et pas PUT ni GET pour ce bouton ?
Réponse : PATCH est utilisé pour effectuer une modification partielle d'une ressource (ici uniquement le statut de publication et sa date), alors que PUT remplace la totalité de la ressource. Le verbe GET, quant à lui, est réservé à la lecture et ne doit jamais modifier l'état des données sur le serveur pour des raisons de sécurité et d'idempotence.