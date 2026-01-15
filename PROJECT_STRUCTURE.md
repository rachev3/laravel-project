# Структура на проекта (Laravel) — къде какво се намира

Този файл описва **папковата структура** на проекта и къде се намират основните части (Movies/Reviews, Upload, Admin, Auth).

## Корен на проекта

-   **`artisan`**: CLI входна точка за Laravel (`php artisan ...`).
-   **`composer.json` / `composer.lock`**: PHP зависимости и Composer скриптове.
-   **`package.json` / `package-lock.json`**: Node зависимости и Vite скриптове (`npm run dev/build`).
-   **`phpunit.xml`**: конфигурация за PHPUnit (в този проект **не поддържаме/не изискваме тестове**, но файлът идва от Laravel skeleton).
-   **`README.md`**: инструкции за старт и демо акаунти.
-   **`PROJECT_PLAN.md`**: план + чеклист на изискванията.

## `app/` (основна логика)

### `app/Models/` — модели

-   **`Movie.php`**: филм (title/year/description/poster_path), релации `genres()`, `reviews()`.
-   **`Genre.php`**: жанр (name/slug), релация `movies()`.
-   **`Review.php`**: ревю (rating/comment/movie_id/user_id), релации към Movie/User.
-   **`User.php`**: потребител; има `is_admin` флаг и релация `reviews()`.

### `app/Http/Controllers/` — контролери

-   **`HomeController.php`**: начална страница `/` с “последно добавени/ревюта/постери”.
-   **`MovieController.php`**: публични страници:
    -   `index()` → `/movies` (търсене по заглавие/жанр, средна оценка + брой ревюта)
    -   `show()` → `/movies/{movie}` (детайли + списък ревюта)
-   **`ReviewController.php`**: CRUD за ревюта (store/update/destroy) към филм (зад `auth`).
-   **`MoviePosterController.php`**: upload/смяна на постер за филм (зад `auth` + admin policy).

#### `app/Http/Controllers/Admin/` — Admin панел

Маршрутите са под `/admin/*` и са защитени с `auth` + `can:admin`.

-   **`AdminDashboardController.php`**: admin dashboard (статистики).
-   **`AdminMovieController.php`**: CRUD за Movies (create/edit/delete).
-   **`AdminGenreController.php`**: CRUD за Genres.
-   **`AdminUserController.php`**: CRUD за Users + задаване на `is_admin`.

#### `app/Http/Controllers/Auth/` — Auth (Breeze)

Тук са контролерите за login/register/logout и профилни действия (генерирани от Breeze).

### `app/Policies/` — политики за права (authorization)

-   **`ReviewPolicy.php`**: update/delete само за автора на ревюто.
-   **`MoviePolicy.php`**: `updatePoster()` — само admin може да качва/сменя постер.

### `app/Providers/`

-   **`AppServiceProvider.php`**:
    -   регистрира policy-тата чрез `Gate::policy(...)`
    -   дефинира `Gate::define('admin')` на база `users.is_admin`

## `routes/` — маршрути

-   **`routes/web.php`**: публични и приложни маршрути:
    -   `/` → Home
    -   `/movies`, `/movies/{movie}` → публични
    -   POST actions за ревюта и постери → зад `auth`
    -   `/admin/*` → зад `auth` + `can:admin`
-   **`routes/auth.php`**: auth маршрути (login/register/logout, profile, password update).

## `resources/views/` — Blade изгледи (UI)

### Layout-и и навигация

-   **`resources/views/layouts/app.blade.php`**: основен layout за логнати и публични страници (включва `layouts/navigation`).
-   **`resources/views/layouts/navigation.blade.php`**: горно меню; показва admin линк само за admin; гостите виждат login/register.
-   **`resources/views/layouts/guest.blade.php`**: layout за auth страници (login/register).

### Публични страници

-   **`resources/views/home.blade.php`**: Home (`/`) — последни филми/ревюта/постери.
-   **`resources/views/movies/index.blade.php`**: списък/търсене на филми.
-   **`resources/views/movies/show.blade.php`**: детайли на филм + ревю форма; показва upload форма за постер само за admin.

### Admin страници

-   **`resources/views/admin/dashboard.blade.php`**: admin dashboard.
-   **`resources/views/admin/_nav.blade.php`**: навигация в admin панела.
-   **`resources/views/admin/movies/*`**: admin Movies CRUD.
-   **`resources/views/admin/genres/*`**: admin Genres CRUD.
-   **`resources/views/admin/users/*`**: admin Users CRUD.

### Auth/Profile страници

-   **`resources/views/auth/*`**: login/register и свързани форми (без forgot/reset/verify).
-   **`resources/views/profile/*`**: профилни страници (update profile/password, delete account).

## `database/` — база, миграции и seed

-   **`database/migrations/`**: създаване на таблици:
    -   `movies`, `genres`, pivot `movie_genre`
    -   `reviews` (вкл. unique `movie_id + user_id`)
    -   `users` (вкл. `is_admin`)
-   **`database/seeders/DatabaseSeeder.php`**: демо данни:
    -   1 admin + 2 normal users
    -   много жанрове/филми
    -   примерни ревюта
-   **`database/database.sqlite`**: SQLite файл (ако е конфигуриран в `.env`).

## `public/` — публично достъпни файлове

-   **`public/index.php`**: entry point за уеб сървъра.
-   **`public/storage`**: symlink към `storage/app/public` (създава се с `php artisan storage:link`).
-   **`public/build`**: Vite build assets (когато пуснеш `npm run build`).

## `storage/` — файлове/кеш/логове

-   **`storage/app/public/`**: качени файлове (постери).  
    В проекта постерите се записват в `storage/app/public/posters/...` и се достъпват през `public/storage/...`.
-   **`storage/logs/laravel.log`**: логове.

## Полезни ориентации

-   **Маршрути**: `routes/web.php`, `routes/auth.php`
-   **Публични Movies страници**: `MovieController` + `resources/views/movies/*`
-   **Ревюта (CRUD + права)**: `ReviewController`, `ReviewPolicy`, `movies/show.blade.php`
-   **Upload на постери**: `MoviePosterController`, `MoviePolicy`, `storage:link`
-   **Admin панел**: `routes/web.php` (`/admin/*`), `app/Http/Controllers/Admin/*`, `resources/views/admin/*`
