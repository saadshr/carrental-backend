<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CarSeeder extends Seeder {
    public function run(): void {
        // Créer admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@carrental.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Créer des voitures
        $cars = [
            ['brand'=>'Toyota', 'model'=>'Corolla', 'license_plate'=>'A-1234-B',
             'type'=>'standard', 'price_per_day'=>350, 'seats'=>5, 'status'=>'available',
             'description'=>'Voiture fiable et économique'],
            ['brand'=>'Dacia',  'model'=>'Logan',   'license_plate'=>'B-5678-C',
             'type'=>'economy', 'price_per_day'=>200, 'seats'=>5, 'status'=>'available',
             'description'=>'Économique et pratique'],
            ['brand'=>'Mercedes','model'=>'Classe C','license_plate'=>'C-9012-D',
             'type'=>'luxury', 'price_per_day'=>900, 'seats'=>5, 'status'=>'available',
             'description'=>'Confort et élégance'],
            ['brand'=>'Renault','model'=>'Clio',    'license_plate'=>'D-3456-E',
             'type'=>'economy', 'price_per_day'=>250, 'seats'=>5, 'status'=>'available',
             'description'=>'Citadine parfaite'],
            ['brand'=>'BMW',    'model'=>'X5',      'license_plate'=>'E-7890-F',
             'type'=>'suv', 'price_per_day'=>1200, 'seats'=>7, 'status'=>'available',
             'description'=>'SUV premium 7 places'],
            ['brand'=>'Hyundai','model'=>'Tucson',  'license_plate'=>'F-1357-G',
             'type'=>'suv', 'price_per_day'=>650, 'seats'=>5, 'status'=>'available',
             'description'=>'SUV spacieux et confortable'],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
