<?php
namespace App\Http\Controllers;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\User;

class DashboardController extends Controller {

    // Dashboard utilisateur
    public function userStats() {
        $userId = auth('api')->id();

        return response()->json([
            'total_reservations'     => Reservation::where('user_id', $userId)->count(),
            'pending_reservations'   => Reservation::where('user_id', $userId)->where('status', 'pending')->count(),
            'confirmed_reservations' => Reservation::where('user_id', $userId)->where('status', 'confirmed')->count(),
            'total_spent'            => Reservation::where('user_id', $userId)
                                         ->whereIn('status', ['confirmed', 'completed'])
                                         ->sum('total_price'),
            'recent_reservations'    => Reservation::with('car')
                                         ->where('user_id', $userId)
                                         ->orderBy('created_at', 'desc')
                                         ->take(3)->get(),
        ]);
    }

    // Dashboard admin
    public function adminStats() {
        return response()->json([
            'total_cars'         => Car::count(),
            'available_cars'     => Car::where('status', 'available')->count(),
            'rented_cars'        => Car::where('status', 'rented')->count(),
            'total_reservations' => Reservation::count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'total_revenue'      => Reservation::whereIn('status', ['confirmed', 'completed'])->sum('total_price'),
            'total_users'        => User::where('role', 'user')->count(),
            'recent_reservations'=> Reservation::with(['car', 'user'])
                                     ->orderBy('created_at', 'desc')
                                     ->take(5)->get(),
        ]);
    }
}