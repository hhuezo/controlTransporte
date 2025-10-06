<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->foreignId('ruta_id')
                ->constrained('rutas')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->foreignId('unidad_id')
                ->constrained('unidades')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->foreignId('motorista_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->date('fecha');
            $table->time('hora_salida')->nullable();
            $table->time('hora_llegada')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['en_ruta', 'finalizado', 'cancelado'])->default('en_ruta');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('viajes');
    }
};
