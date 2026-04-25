<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
    protected $fillable = [
        'user_id', 'car_id', 'start_date', 'end_date',
        'total_days', 'total_price', 'status', 'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Une réservation appartient à un utilisateur
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Une réservation appartient à une voiture
    public function car() {
        return $this->belongsTo(Car::class);
    }
}