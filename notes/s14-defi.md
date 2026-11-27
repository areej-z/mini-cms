# Session 14 - Défi

Connexion enregistre le jeton toute seule : oui
Créer un article répond 201 sans copier le jeton : oui
Le fichier exporté ne contient aucun jeton : oui

Pourquoi les écritures de l'API passent-elles par les Form Requests et PostPolicy plutôt que par des règles écrites dans Api\PostController ?
Une seule règle pour deux portes : un changement de la Policy ou des règles de validation s'applique à la fois au site web et à l'API. Cela évite la duplication de code et garantit que le site et l'API ne peuvent jamais se contredire.

Le dépôt est public. Que risquez-vous si le fichier exporté contient un jeton, et comment l'annuler ?
N'importe qui peut agir en notre nom tant que le jeton n'est pas révoqué car il n'expire jamais par défaut. Pour l'annuler, il faut appeler /api/logout avec ce jeton, ou supprimer la ligne correspondante dans la table personal_access_tokens.
