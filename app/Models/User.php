<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {
    protected $fillable = ['name', 'email', 'password', 'phone', 'role'];

    protected $hidden = ['password', 'remember_token'];

    // Requis pour JWT
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    // Un utilisateur a plusieurs réservations
    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }
}
