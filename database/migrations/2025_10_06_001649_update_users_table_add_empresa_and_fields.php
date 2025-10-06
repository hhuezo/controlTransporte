<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('empresa_id')
                ->nullable()
                ->constrained('empresas')
                ->restrictOnDelete()
                ->restrictOnUpdate();
            $table->string('pin', 8)->nullable();
            $table->string('numero_licencia', 50)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropColumn(['empresa_id', 'numero_licencia', 'foto', 'pin', 'telefono', 'direccion']);
        });
    }
};
