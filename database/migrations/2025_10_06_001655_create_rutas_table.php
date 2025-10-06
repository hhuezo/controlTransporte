<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rutas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->decimal('distancia_km', 8, 2)->nullable();
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rutas');
    }
};
