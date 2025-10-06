<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('puntos_control', function (Blueprint $table) {
            $table->id();

            $table->foreignId('viaje_id')
                ->constrained('viajes')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->foreignId('motorista_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->enum('tipo', ['entrada', 'salida', 'parada', 'otro'])->default('entrada');
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->dateTime('hora_reporte');
            $table->text('observacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('puntos_control');
    }
};
