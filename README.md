<div align="center">

<img width="100%" src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=6,11,20&height=180&section=header&text=🚗%20Car%20Rental%20System&fontSize=50&fontColor=fff&animation=fadeIn&fontAlignY=38&desc=Full%20Stack%20Application%20%7C%20Laravel%20%2B%20React&descAlignY=58&descSize=18"/>

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![React](https://img.shields.io/badge/React-18-61DAFB?style=for-the-badge&logo=react&logoColor=black)](https://reactjs.org)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-005C84?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![JWT](https://img.shields.io/badge/JWT-Auth-000000?style=for-the-badge&logo=jsonwebtokens&logoColor=white)](https://jwt.io)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)

</div>

---

## 📋 Table des matières

- [📖 Description](#-description)
- [✨ Fonctionnalités](#-fonctionnalités)
- [🏗️ Architecture](#️-architecture)
- [🗄️ Base de données](#️-base-de-données)
- [🚀 Installation](#-installation)
- [📡 API Endpoints](#-api-endpoints)
- [📸 Screenshots](#-screenshots)
- [👤 Auteur](#-auteur)

---

## 📖 Description

**Car Rental System** est une application web full stack de location de voitures construite avec **Laravel** (backend API) et **React** (frontend). Elle permet à des utilisateurs de parcourir un catalogue de voitures, faire des réservations, et à un admin de gérer l'ensemble du système.

---

## ✨ Fonctionnalités

### 👤 Utilisateur
- ✅ Inscription et connexion sécurisée (JWT)
- ✅ Parcourir le catalogue de voitures
- ✅ Filtrer par type, prix, recherche
- ✅ Réserver une voiture avec calcul automatique du prix
- ✅ Consulter et annuler ses réservations
- ✅ Dashboard personnel avec statistiques

### 🔧 Administrateur
- ✅ CRUD complet des voitures
- ✅ Voir toutes les réservations
- ✅ Confirmer / annuler des réservations
- ✅ Dashboard avec statistiques globales (revenus, etc.)

---

## 🏗️ Architecture

```
car-rental/
│
├── 📁 backend/                 # Laravel API
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── CarController.php
│   │   │   │   ├── ReservationController.php
│   │   │   │   └── DashboardController.php
│   │   │   └── Middleware/
│   │   │       └── AdminMiddleware.php
│   │   └── Models/
│   │       ├── User.php
│   │       ├── Car.php
│   │       └── Reservation.php
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   └── routes/
│       └── api.php
│
└── 📁 frontend/                # React App
    └── src/
        ├── components/
        │   └── Navbar.jsx
        ├── pages/
        │   ├── Home.jsx
        │   ├── Login.jsx
        │   ├── Register.jsx
        │   ├── CarDetail.jsx
        │   ├── MyReservations.jsx
        │   ├── UserDashboard.jsx
        │   └── AdminDashboard.jsx
        └── services/
            ├── api.js
            ├── authService.js
            ├── carService.js
            └── reservationService.js
```

---

## 🗄️ Base de données

```
┌─────────────┐       ┌──────────────────┐       ┌─────────────┐
│    users    │       │   reservations   │       │    cars     │
├─────────────┤       ├──────────────────┤       ├─────────────┤
│ id          │──┐    │ id               │    ┌──│ id          │
│ name        │  └───►│ user_id (FK)     │    │  │ brand       │
│ email       │       │ car_id (FK)      │◄───┘  │ model       │
│ password    │       │ start_date       │       │ license_plate│
│ phone       │       │ end_date         │       │ type        │
│ role        │       │ total_days       │       │ price_per_day│
│ created_at  │       │ total_price      │       │ status      │
└─────────────┘       │ status           │       │ seats       │
                      │ notes            │       │ image       │
                      └──────────────────┘       └─────────────┘
```

---

## 🚀 Installation

### Prérequis
- PHP >= 8.1
- Composer
- Node.js >= 18
- MySQL (XAMPP)

### 1. Cloner les repos

```bash
git clone https://github.com/saadshr/carrental-backend.git backend
git clone https://github.com/saadshr/carrental-frontend.git frontend
```

### 2. Backend — Laravel

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

Modifier `.env` :
```env
DB_DATABASE=car_rental
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate
php artisan db:seed --class=CarSeeder
php artisan serve
```

### 3. Frontend — React

```bash
cd frontend
npm install
npm start
```

### 4. Accès

| Service | URL |
|---------|-----|
| Frontend | http://localhost:3000 |
| Backend API | http://localhost:8000 |
| phpMyAdmin | http://localhost/phpmyadmin |

### 5. Compte Admin par défaut

```
Email    : admin@carrental.com
Password : password123
```

---

## 📡 API Endpoints

### 🔓 Public
| Méthode | Endpoint | Description |
|---------|----------|-------------|
| POST | `/api/register` | Créer un compte |
| POST | `/api/login` | Se connecter |
| GET | `/api/cars` | Liste des voitures |
| GET | `/api/cars/{id}` | Détail voiture |
| GET | `/api/cars?type=suv` | Filtrer par type |
| GET | `/api/cars?max_price=500` | Filtrer par prix |

### 🔐 Authentifié (Bearer Token)
| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/me` | Profil utilisateur |
| POST | `/api/logout` | Déconnexion |
| GET | `/api/reservations` | Mes réservations |
| POST | `/api/reservations` | Créer réservation |
| PUT | `/api/reservations/{id}/cancel` | Annuler |
| GET | `/api/dashboard` | Stats utilisateur |

### 👑 Admin uniquement
| Méthode | Endpoint | Description |
|---------|----------|-------------|
| POST | `/api/cars` | Ajouter voiture |
| PUT | `/api/cars/{id}` | Modifier voiture |
| DELETE | `/api/cars/{id}` | Supprimer voiture |
| GET | `/api/admin/reservations` | Toutes réservations |
| PUT | `/api/admin/reservations/{id}/confirm` | Confirmer |
| GET | `/api/admin/dashboard` | Stats admin |

---

## 📸 Screenshots

### 🏠 Page d'accueil — Catalogue voitures
> Liste des voitures avec filtres par type, prix et recherche

### 📅 Page détail — Réservation
> Formulaire de réservation avec calcul automatique du prix total

### 📋 Mes réservations
> Historique des réservations avec statuts (En attente / Confirmée / Annulée)

### 📊 Dashboard utilisateur
> Statistiques personnelles et réservations récentes

### ⚙️ Dashboard Admin
> Gestion complète des voitures et réservations

---

## 👤 Auteur

**Saad Sahraoui**

[![GitHub](https://img.shields.io/badge/GitHub-saadshr-100000?style=for-the-badge&logo=github)](https://github.com/saadshr)
[![Gmail](https://img.shields.io/badge/Gmail-saad20azmm@gmail.com-D14836?style=for-the-badge&logo=gmail)](mailto:saad20azmm@gmail.com)

---

<div align="center">

⭐ **Si ce projet t'a aidé, n'hésite pas à mettre une étoile !** ⭐

<img width="100%" src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=6,11,20&height=100&section=footer"/>

</div>