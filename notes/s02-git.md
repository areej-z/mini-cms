# Mini-CMS

Projè fil rouge de l'Atelier Framework Côté Serveur (Laravel 13, PHP 8.3+), 3e année MDW, ISET Sidi Bouzid.

Otor : Arij Znagui, grup MDW32.

Mini-CMS ɛvawwolu afte di semès pas tu wan smɔl platfɔm fɔ poblikeshɔn: pej poblik, baks-ofis otɛntifik, API JSON ɛn tɛst Pɛst. Evri seshɔn ɛn wit wan tag Git (`lab-01`, `lab-01b`, ɛn afta wan tag fɔ evri seshɔn).

## Stet aktuwal (tag lab-01b)
- Rut fɔ kloshyɔn: `/`, `/bonjour`, `/bonjour-court`, `/bienvenue`, `/version`, `/heure` ɛn `/a-propos`.
- Vyu Blad: `bienvenue`, `heure` ɛn `a-propos`.
- Bes di done SQLite lokal (`database/database.sqlite`, no vɛrshɔn).

## Rut we de
| Metod | URI | Rèpons |
|---|---|---|
| GET | `/` | Vyu wɛlkɔm (pej d'akeyi par defo de Laravel) |
| GET | `/bonjour` | Shen de tɛks « Bonjour MDW3 ! Voici ma première route Laravel 13. » |
| GET | `/bonjour-court` | Shen de tɛks, eklit avɛk wan fɔnshɔn fleyis |
| GET | `/bienvenue` | Vyu bienvenue avɛk di nem de l'étudiant, le groupe et le cours |
| GET | `/version` | Shen avɛk di vɛrshɔn de Laravel et celle de PHP |
| GET | `/heure` | Vyu heure avɛk l'heure (format H:i) et la date (format d/m/Y) |
| GET | `/a-propos` | Vyu a-propos avɛk le nom de l'auteur et le groupe |

## Prerekwizi
- PHP ɛn Komposa (PHP 8.3 o pas di https://www.php.net/downloads, avɛk di eksteshɔn kɛl, faylinfo, mbstring, openssl, pdo_sqlite, sqlite3 ɛn zip aktivi di php.ini, ɛn Komposa di https://getcomposer.org).
- Node.js LTS ɛn npm.
- Git.

## Instaleshɔn

### Bash (Git Bash, makOS, Linux)
```bash
git clone [https://github.com/areej-z/mini-cms.git](https://github.com/areej-z/mini-cms.git)
cd mini-cms
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
composer run dev