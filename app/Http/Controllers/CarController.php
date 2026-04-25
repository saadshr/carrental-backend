<?php
namespace App\Http\Controllers;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller {

    // GET /api/cars — Liste toutes les voitures (avec filtres optionnels)
    public function index(Request $request) {
        $query = Car::query();

        // Filtrer par type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filtrer par statut
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filtrer par prix max
        if ($request->has('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        // Recherche par marque ou modèle
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('brand', 'like', '%'.$request->search.'%')
                  ->orWhere('model', 'like', '%'.$request->search.'%');
            });
        }

        $cars = $query->orderBy('created_at', 'desc')->get();

        return response()->json($cars);
    }

    // GET /api/cars/{id}
    public function show($id) {
        $car = Car::findOrFail($id);
        return response()->json($car);
    }

    // POST /api/cars (admin)
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'brand'         => 'required|string',
            'model'         => 'required|string',
            'license_plate' => 'required|string|unique:cars',
            'type'          => 'required|in:economy,standard,luxury,suv',
            'price_per_day' => 'required|numeric|min:0',
            'seats'         => 'integer|min:2|max:9',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $car = Car::create($request->all());
        return response()->json($car, 201);
    }

    // PUT /api/cars/{id} (admin)
    public function update(Request $request, $id) {
        $car = Car::findOrFail($id);
        $car->update($request->all());
        return response()->json($car);
    }

    // DELETE /api/cars/{id} (admin)
    public function destroy($id) {
        $car = Car::findOrFail($id);
        $car->delete();
        return response()->json(['message' => 'Voiture supprimée']);
    }
}
