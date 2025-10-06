<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->string('codigo', 50);
            $table->string('placa', 20);
            $table->enum('tipo', ['bus', 'coaster', 'microbus', 'otro'])->default('bus');
            $table->integer('capacidad')->nullable();
            $table->string('marca', 100)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->integer('anio')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('unidades');
    }
};
