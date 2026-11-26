# Mini-CMS

Projet fil rouge de l'Atelier Framework Côté Serveur (Laravel 13, PHP 8.3+), 3e année MDW, ISET Sidi Bouzid.

Auteur : Arij Znagui, groupe MDW32.

Mini-CMS évoluera au fil du semestre vers une petite plateforme de publication : pages publiques, back-office authentifié, API JSON et tests Pest. Chaque session se termine par un tag Git (`lab-01`, `lab-01b`, puis un tag par session).

## État actuel (tag lab-06)

- Comptes écrits à la main : inscription (`/inscription`), connexion (`/connexion`) et déconnexion, avec `Hash::make`, `Auth::attempt` et la régénération de la session.
- Colonne `role` (`author` par défaut, `admin`). Après `php artisan migrate:fresh --seed`, le compte de démonstration `test@example.com` (mot de passe `password`) est administrateur.
- Écritures et back-office réservés aux utilisateurs connectés (middleware `auth`) ; chaque nouvel article est attaché à son auteur.
- Gate `manage-categories` : seuls les administrateurs gèrent les catégories.
- `PostPolicy` : un auteur modifie et supprime ses articles, un administrateur tous les articles.
- Tests Pest : `PostPagesTest`, `PostWriteTest`, `PostRelationsTest`, `PostTaxonomyTest`, `PostFeedbackTest`, `CategoryAdminTest`, `ErrorPagesTest`, `AuthTest` et `AuthorizationTest`.

## Routes disponibles

| Méthode | URI | Nom | Action |
|---|---|---|---|
| GET | `/` | `home` | `PageController@home` |
| GET | `/a-propos` | `about` | `PageController@about` |
| GET | `/heure` | `time` | `PageController@time` |
| GET | `/posts` | `posts.index` | `PostController@index` |
| GET | `/posts/archive/{year}` | `posts.archive` | `PostController@archive` |
| GET | `/posts/categorie/{category:slug}` | `posts.category` | `PostController@byCategory` |
| GET | `/posts/tag/{tag:slug}` | `posts.tag` | `PostController@byTag` |
| GET | `/posts/create` | `posts.create` | `PostController@create` |
| POST | `/posts` | `posts.store` | `PostController@store` |
| GET | `/posts/{post}` | `posts.show` | `PostController@show` |
| GET | `/posts/{post}/edit` | `posts.edit` | `PostController@edit` |
| PUT | `/posts/{post}` | `posts.update` | `PostController@update` |
| DELETE | `/posts/{post}` | `posts.destroy` | `PostController@destroy` |
| PATCH | `/posts/{post}/publication` | `posts.publication` | `PostController@togglePublication` |
| GET | `/admin/categories` | `admin.categories.index` | `CategoryController@index` |
| GET | `/admin/categories/create` | `admin.categories.create` | `CategoryController@create` |
| POST | `/admin/categories` | `admin.categories.store` | `CategoryController@store` |
| GET | `/admin/categories/{category}/edit` | `admin.categories.edit` | `CategoryController@edit` |
| PUT | `/admin/categories/{category}` | `admin.categories.update` | `CategoryController@update` |
| DELETE | `/admin/categories/{category}` | `admin.categories.destroy` | `CategoryController@destroy` |
| GET | `/admin/tags` | `admin.tags.index` | `TagController@index` |
| GET | `/admin/tags/create` | `admin.tags.create` | `TagController@create` |
| POST | `/admin/tags` | `admin.tags.store` | `TagController@store` |
| GET | `/admin/tags/{tag}/edit` | `admin.tags.edit` | `TagController@edit` |
| PUT | `/admin/tags/{tag}` | `admin.tags.update` | `TagController@update` |
| DELETE | `/admin/tags/{tag}` | `admin.tags.destroy` | `TagController@destroy` |
| GET | `/inscription` | `register` | `Auth\RegisterController@create` |
| POST | `/inscription` | `register.store` | `Auth\RegisterController@store` |
| GET | `/connexion` | `login` | `Auth\LoginController@create` |
| POST | `/connexion` | `login.store` | `Auth\LoginController@store` |
| POST | `/deconnexion` | `logout` | `Auth\LoginController@destroy` |

## Prérequis
- PHP et Composer (PHP 8.3 ou plus depuis https://www.php.net/downloads, avec les extensions curl, fileinfo, mbstring, openssl, pdo_sqlite, sqlite3 et zip activées dans php.ini, et Composer depuis https://getcomposer.org).
- Node.js LTS et npm.
- Git.

## Installation

### Bash (Git Bash, macOS, Linux)
```bash
git clone https://github.com/areej-z/mini-cms.git
cd mini-cms
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
composer run dev
```

## Captures d'écran

### Session 01
![Accueil de Mini-CMS](screenshots/s01-accueil.png)
![Page de bienvenue](screenshots/s01-bienvenue.png)
![Liste des routes](screenshots/s01-route-list.png)

### Session 02
![Page À propos](screenshots/s02-a-propos.png)

### Session 03
![Accueil avec les articles](screenshots/s03-accueil.png)
![Détail d'un article](screenshots/s03-article.png)
![Liste des articles](screenshots/s03-articles.png)

### Autre capture
![Page Heure et Date](screenshots/heure.png)

### Session 04
![Liste des articles](screenshots/s04-articles.png)

### Session 05
![Liste paginée des articles](screenshots/s05-articles.png)
![Formulaire avec erreurs de validation](screenshots/s05-formulaire.png)

### Session 06
![Formulaire de modification prérempli](screenshots/s06-modification.png)
![Confirmation de suppression](screenshots/s06-suppression.png)

### Session 07

![Liste des articles avec leur catégorie, leur auteur et leurs tags](screenshots/s07-liste-relations.png)

![Page d'un article avec ses tags et les articles de la même catégorie](screenshots/s07-detail-tags.png)

### Session 08

![Formulaire de modification avec la catégorie et les tags](screenshots/s08-formulaire-relations.png)

![Page des articles d'une catégorie](screenshots/s08-page-categorie.png)

### Session 09

![Page d'un article avec le message flash « Article créé. »](screenshots/s09-message-flash.png)

![Page Article introuvable pour un identifiant inexistant](screenshots/s09-article-introuvable.png)

### Session 10

Back-office des catégories et des tags, messages de validation en français, pages 404 et 503 dans le layout du site.

![Formulaire de catégorie envoyé vide, avec les messages de validation en français](screenshots/s10-validation.png)

![Page 404 du site pour une adresse inconnue](screenshots/s10-404.png)

### Session 11

![Barre de navigation d'un utilisateur connecté, avec le message « Vous êtes connecté. »](screenshots/s11-connexion.png)

![Page 403 quand un auteur ouvre la modification de l'article d'un autre auteur](screenshots/s11-interdit.png)

## Comparaison avec le starter kit Livewire

| Critère | Mini-CMS (authentification manuelle) | Starter kit Livewire |
|---|---|---|
| Routes d'authentification | Déclarées dans `routes/web.php` (`/inscription`, `/connexion`, `/deconnexion`) | Enregistrées automatiquement par Laravel Fortify (absentes de `routes/web.php`) |
| Inscription | `Auth\RegisterController` et `RegisterRequest` avec `Hash::make()` | `app/Actions/Fortify/CreateNewUser.php` et vue Livewire |
| Connexion | `Auth\LoginController::store` (`Auth::attempt`, `session()->regenerate()`) | Contrôleur Fortify et vue Livewire |
| Déconnexion | `Auth\LoginController::destroy` (`logout`, `invalidate`, `regenerateToken`) | Route Fortify et `app/Livewire/Actions/Logout.php` |
| Limitation des tentatives | Aucune | 5 tentatives par minute par e-mail et IP (`FortifyServiceProvider`) |
| Mot de passe oublié | Absent | Intégré (`Features::resetPasswords()` dans `config/fortify.php`) |
| Vérification de l'e-mail | Absente | Intégrée (`Features::emailVerification()`, `MustVerifyEmail`, middleware `verified`) |
| Double authentification | Absente | Intégrée (`Features::twoFactorAuthentication()` et passkeys) |
| Rôles et autorisations | Colonne `role`, middleware `EnsureUserIsAdmin`, Gates dans `AppServiceProvider`, `PostPolicy` | Aucun : à implémenter soi-même |
| Tests | `AuthTest`, `AuthorizationTest`, `AdminAccessTest`, `PostVisibilityTest` (Pest) | Suite de tests fournie pour Auth, Settings et Dashboard |

Ce que je garderais du kit dans un vrai projet : Je garderais la limitation des tentatives de connexion, la réinitialisation du mot de passe et la vérification d'e-mail fournies par Fortify, qui sont fastidieuses et sensibles à écrire à la main. En revanche, il reste indispensable d'écrire soi-même les rôles, les middlewares, les Gates et les Policies propres au métier de l'application.

