<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CarSeeder extends Seeder {
    public function run(): void {
        // Créer ou mettre à jour l'admin sans provoquer d'erreur si le seeder est relancé.
        User::updateOrCreate(
            ['email' => 'admin@carrental.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

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

        // Ajouter une voiture "aléatoire" supplémentaire pour compléter la page
        $cars[] = [
            'brand' => 'Audi', 'model' => 'A4', 'license_plate' => 'G-2468-H',
            'type' => 'standard', 'price_per_day' => 480, 'seats' => 5, 'status' => 'available',
            'description' => 'Berline raffinée et performante'
        ];

        // Images fixes par modele. Eviter les services aleatoires pour garder la meme image a chaque refresh.
        $images = [
            'Toyota Corolla' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Toyota_Corolla_%2829893898867%29.jpg?width=1400',
            'Dacia Logan' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Dacia_Logan_III.jpg?width=1400',
            'Mercedes Classe C' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Mercedes-Benz_C-Class_%2849214146168%29.jpg?width=1400',
            'Renault Clio' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Renault_Clio_Greenshield.jpg?width=1400',
            'BMW X5' => 'https://commons.wikimedia.org/wiki/Special:FilePath/BMW_X5_F15.jpg?width=1400',
            'Hyundai Tucson' => 'https://commons.wikimedia.org/wiki/Special:FilePath/2019_Hyundai_Tucson.jpg?width=1400',
            'Audi A4' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Audi_A4_B8.jpg?width=1400',
        ];

        foreach ($cars as $car) {
            $title = "{$car['brand']} {$car['model']}";
            $car['image'] = $images[$title] ?? 'https://loremflickr.com/1400/800/car/all';
            Car::updateOrCreate(
                ['license_plate' => $car['license_plate']],
                $car
            );
        }
    }
}
