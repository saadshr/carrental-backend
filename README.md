# 🚗 Car Rental · Backend

![PHP 8.2+](https://img.shields.io/badge/PHP-8.2%2B-565B91?style=for-the-badge&logo=php&logoColor=white)
![Laravel 11](https://img.shields.io/badge/Laravel-11-BD231E?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-315C73?style=for-the-badge&logo=mysql&logoColor=white)
![JWT](https://img.shields.io/badge/JWT-613287?style=for-the-badge&logo=jsonwebtokens&logoColor=white)
![Composer 2](https://img.shields.io/badge/Composer-2-6D4C41?style=for-the-badge&logo=composer&logoColor=white)

[Installation](#installation-locale) · [Routes API](#api)

---

API REST Laravel 11 pour le catalogue de voitures, les réservations et les tableaux de bord. Les opérations protégées utilisent un jeton JWT. Le frontend est maintenu dans un dépôt séparé. [Car Rental Frontend](https://github.com/saadshr/carrental-frontend)

## Installation locale

Prérequis · PHP 8.2 ou supérieur compatible avec Laravel 11, Composer 2 et MySQL avec l'extension PHP `pdo_mysql`. Créer une base vide nommée `car_rental` et un compte MySQL autorisé à y effectuer les migrations.

Depuis le dossier qui contient les dépôts, cloner le backend si nécessaire.

```powershell
git clone https://github.com/saadshr/carrental-backend.git
Set-Location carrental-backend
composer install
```

Créer un fichier `.env` à la racine et remplacer les identifiants MySQL par ceux de ton environnement local. Les commandes Artisan rempliront `APP_KEY` et `JWT_SECRET`.

```dotenv
APP_NAME="Car Rental"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_KEY=
JWT_SECRET=

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=car_rental
DB_USERNAME=car_rental
DB_PASSWORD=mot_de_passe_local

CACHE_STORE=file
SESSION_DRIVER=file
```

```powershell
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan serve --host=127.0.0.1 --port=8000
```

Vérifier [l'état du serveur](http://127.0.0.1:8000/up) et [le catalogue](http://127.0.0.1:8000/api/cars). Pour charger des véhicules de démonstration et le compte administrateur de test, exécuter `php artisan db:seed --class=CarSeeder` sur une base locale de développement. Le compte de démonstration est défini dans [CarSeeder.php](database/seeders/CarSeeder.php).

## API

Les routes ci-dessous sont préfixées par `/api`. Envoyer `Accept: application/json`. Pour les opérations authentifiées, ajouter `Authorization: Bearer <token>` avec le jeton reçu à la connexion ou à l'inscription.

- Public · `POST /register`, `POST /login`, `GET /cars`, `GET /cars/{id}`.
- Utilisateur · `GET /me`, `POST /logout`, `GET /dashboard`, `GET /reservations`, `POST /reservations`, `PUT /reservations/{id}/cancel`.
- Administrateur · `POST /cars`, `PUT /cars/{id}`, `DELETE /cars/{id}`, `GET /admin/dashboard`, `GET /admin/reservations`, `PUT /admin/reservations/{id}/confirm`.

Le catalogue accepte les filtres `type`, `status`, `max_price` et `search`. Une réservation utilise `car_id`, `start_date`, `end_date` et un champ facultatif `notes`. Le serveur calcule le prix à partir du tarif journalier et de la durée de location.

Les routes sont définies dans [routes/api.php](routes/api.php), les migrations dans [database/migrations](database/migrations) et les origines autorisées pour le frontend dans [config/cors.php](config/cors.php).

## Auteur

Saad Sahraoui · [GitHub](https://github.com/saadshr)
