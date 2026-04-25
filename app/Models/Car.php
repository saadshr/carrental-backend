<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Car extends Model {
    protected $fillable = [
        'brand', 'model', 'license_plate', 'type',
        'price_per_day', 'image', 'status', 'description', 'seats'
    ];

    // Une voiture a plusieurs réservations
    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    // Scope pour filtrer les voitures disponibles
    public function scopeAvailable($query) {
        return $query->where('status', 'available');
    }

    // Scope pour filtrer par type
    public function scopeOfType($query, $type) {
        return $query->where('type', $type);
    }
}