# 📋 Architecture Backend - Car Rental API

## 🏗️ Structure créée

```
backend/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php         ← Authentification (Login/Register)
│   │   ├── CarController.php          ← Gestion des voitures (CRUD)
│   │   ├── ReservationController.php  ← Gestion des réservations
│   │   └── DashboardController.php    ← Statistiques
│   └── Models/
│       ├── User.php                   ← Modèle Utilisateur
│       ├── Car.php                    ← Modèle Voiture
│       └── Reservation.php            ← Modèle Réservation
├── config/
│   ├── auth.php                       ← Configuration JWT
│   ├── database.php                   ← Configuration MySQL
│   └── jwt.php                        ← Configuration JWT (auto-généré)
├── database/migrations/
│   ├── create_users_table.php         ← Crée la table users
│   ├── create_cars_table.php          ← Crée la table cars
│   └── create_reservations_table.php  ← Crée la table reservations
├── routes/
│   └── api.php                        ← Toutes les routes API
├── .env                               ← Configuration BDD
└── artisan                            ← CLI Laravel
```

---

## 🔑 Points clés

### **Controllers** (Logique métier)
- **AuthController** : Login, Register, Profile, Logout
- **CarController** : Liste, Créer, Modifier, Supprimer voitures
- **ReservationController** : Créer, Lister, Modifier statut, Annuler réservation
- **DashboardController** : Statistiques globales

### **Models** (Représentation des données)
- **User** : Utilisateurs (name, email, password, phone, address)
- **Car** : Voitures (brand, model, year, price_per_day, image, description)
- **Reservation** : Réservations (user_id, car_id, dates, prix, status)

### **Migrations** (Création des tables)
Exécutées avec `php artisan migrate` :
- `users` : Stocke les utilisateurs
- `cars` : Stocke les voitures
- `reservations` : Stocke les réservations (avec contraintes de clés étrangères)

### **Routes API**
**Publiques** :
- `POST /api/auth/register` → Créer compte
- `POST /api/auth/login` → Se connecter
- `GET /api/cars` → Lister voitures
- `GET /api/cars/{id}` → Détails voiture

**Protégées (JWT)** :
- `POST /api/auth/logout` → Se déconnecter
- `GET /api/auth/profile` → Profil utilisateur
- `POST /api/reservations` → Créer réservation
- `GET /api/reservations/my-reservations` → Mes réservations
- `GET /api/dashboard/stats` → Statistiques
- Etc.

---

## 🚀 Prochaines étapes

### 1. **Exécuter les migrations** (créer les tables)
```bash
cd backend
php artisan migrate
```

### 2. **Tester l'API** avec Postman/Insomnia
```bash
POST /api/auth/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "0123456789"
}
```

### 3. **Démarrer le serveur Laravel**
```bash
php artisan serve
```

Serveur disponible à : `http://localhost:8000`

---

## 📝 Notes importantes

1. **JWT** : Tous les tokens sont générés automatiquement au login
2. **Relations** : 
   - Un User peut faire N Reservations
   - Une Car peut avoir N Reservations
   - Une Reservation appartient à 1 User et 1 Car
3. **Statuts de réservation** : pending, confirmed, cancelled, completed
4. **Validation** : Tous les inputs sont validés côté backend

---

## ✅ Architecture validée et prête pour le développement !
