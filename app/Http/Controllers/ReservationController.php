<?php
namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReservationController extends Controller {

    // GET /api/reservations — Mes réservations
    public function index() {
        $reservations = Reservation::with('car')
            ->where('user_id', auth('api')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reservations);
    }

    // GET /api/admin/reservations — Toutes les réservations (admin)
    public function adminIndex() {
        $reservations = Reservation::with(['car', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reservations);
    }

    // POST /api/reservations — Créer une réservation
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'car_id'     => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
            'notes'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $car = Car::findOrFail($request->car_id);

        // Vérifier si la voiture est disponible
        if ($car->status !== 'available') {
            return response()->json(['error' => 'Cette voiture n\'est pas disponible'], 400);
        }

        // Calculer le prix total
        $startDate  = Carbon::parse($request->start_date);
        $endDate    = Carbon::parse($request->end_date);
        $totalDays  = $startDate->diffInDays($endDate);
        $totalPrice = $totalDays * $car->price_per_day;

        // Créer la réservation
        $reservation = Reservation::create([
            'user_id'     => auth('api')->id(),
            'car_id'      => $request->car_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'total_days'  => $totalDays,
            'total_price' => $totalPrice,
            'status'      => 'pending',
            'notes'       => $request->notes,
        ]);

        // Mettre la voiture en "rented"
        $car->update(['status' => 'rented']);

        return response()->json(
            $reservation->load('car'),
            201
        );
    }

    // PUT /api/reservations/{id}/cancel — Annuler
    public function cancel($id) {
        $reservation = Reservation::where('user_id', auth('api')->id())
            ->findOrFail($id);

        if (!in_array($reservation->status, ['pending', 'confirmed'])) {
            return response()->json(['error' => 'Impossible d\'annuler cette réservation'], 400);
        }

        $reservation->update(['status' => 'cancelled']);

        // Remettre la voiture disponible
        $reservation->car->update(['status' => 'available']);

        return response()->json(['message' => 'Réservation annulée', 'reservation' => $reservation]);
    }

    // PUT /api/admin/reservations/{id}/confirm — Confirmer (admin)
    public function confirm($id) {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'confirmed']);
        return response()->json($reservation->load(['car', 'user']));
    }
}
