<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand');           // Marque (Toyota, Renault...)
            $table->string('model');           // Modèle (Corolla, Clio...)
            $table->string('license_plate')->unique(); // Immatriculation
            $table->enum('type', ['economy', 'standard', 'luxury', 'suv'])->default('standard');
            $table->decimal('price_per_day', 8, 2);  // Prix par jour
            $table->string('image')->nullable();      // Image URL
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available');
            $table->text('description')->nullable();
            $table->integer('seats')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cars');
    }
};