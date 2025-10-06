<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SistemaTransporteSeeder extends Seeder
{
    public function run(): void
    {
        // -----------------------
        // Empresas
        // -----------------------
        $empresa1Id = DB::table('empresas')->insertGetId([
            'nombre' => 'Transporte Rápido',
            'direccion' => 'San Salvador',
            'telefono' => '7777-0001',
            'correo' => 'contacto@transporterapido.com',
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $empresa2Id = DB::table('empresas')->insertGetId([
            'nombre' => 'Coasters Express',
            'direccion' => 'Santa Ana',
            'telefono' => '7777-0002',
            'correo' => 'info@coastersexpress.com',
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // -----------------------
        // Usuarios
        // -----------------------

          $admin = DB::table('users')->insertGetId([
            'name' => 'Administrador',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Motoristas
        $motorista1Id = DB::table('users')->insertGetId([
            'name' => 'Juan Pérez',
            'email' => 'juan@transporterapido.com',
            'password' => Hash::make('12345678'),
            'empresa_id' => $empresa1Id,
            'numero_licencia' => 'LIC12345',
            'pin' => rand(10000, 99999), // PIN aleatorio de 5 dígitos
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $motorista2Id = DB::table('users')->insertGetId([
            'name' => 'Carlos Gómez',
            'email' => 'carlos@coastersexpress.com',
            'password' => Hash::make('12345678'),
            'empresa_id' => $empresa2Id,
            'numero_licencia' => 'LIC54321',
            'pin' => rand(10000, 99999), // PIN aleatorio de 5 dígitos
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Administradores
        DB::table('users')->insert([
            [
                'name' => 'Admin Rápido',
                'email' => 'admin@transporterapido.com',
                'password' => Hash::make('12345678'),
                'empresa_id' => $empresa1Id,
                'pin' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Coasters',
                'email' => 'admin@coastersexpress.com',
                'password' => Hash::make('12345678'),
                'empresa_id' => $empresa2Id,
                'pin' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Digitadores
        DB::table('users')->insert([
            [
                'name' => 'Ana López',
                'email' => 'ana@transporterapido.com',
                'password' => Hash::make('12345678'),
                'empresa_id' => $empresa1Id,
                'pin' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laura Martínez',
                'email' => 'laura@coastersexpress.com',
                'password' => Hash::make('12345678'),
                'empresa_id' => $empresa2Id,
                'pin' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);


        // -----------------------
        // Unidades
        // -----------------------
        $bus1Id = DB::table('unidades')->insertGetId([
            'empresa_id' => $empresa1Id,
            'codigo' => 'BUS-01',
            'placa' => 'ABC-123',
            'tipo' => 'bus',
            'capacidad' => 40,
            'marca' => 'Mercedes',
            'modelo' => 'Sprinter',
            'anio' => 2020,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $coaster1Id = DB::table('unidades')->insertGetId([
            'empresa_id' => $empresa2Id,
            'codigo' => 'COA-01',
            'placa' => 'XYZ-789',
            'tipo' => 'coaster',
            'capacidad' => 20,
            'marca' => 'Toyota',
            'modelo' => 'Coaster',
            'anio' => 2018,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // -----------------------
        // Rutas
        // -----------------------
        $ruta1Id = DB::table('rutas')->insertGetId([
            'empresa_id' => $empresa1Id,
            'nombre' => 'San Salvador - Santa Tecla',
            'descripcion' => 'Ruta principal de transporte rápido',
            'distancia_km' => 15,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $ruta2Id = DB::table('rutas')->insertGetId([
            'empresa_id' => $empresa2Id,
            'nombre' => 'Santa Ana - Chalchuapa',
            'descripcion' => 'Ruta express de Coasters Express',
            'distancia_km' => 20,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // -----------------------
        // Viajes
        // -----------------------
        $viaje1Id = DB::table('viajes')->insertGetId([
            'empresa_id' => $empresa1Id,
            'ruta_id' => $ruta1Id,
            'unidad_id' => $bus1Id,
            'motorista_id' => $motorista1Id,
            'fecha' => Carbon::today()->format('Y-m-d'),
            'hora_salida' => '07:00',
            'estado' => 'en_ruta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $viaje2Id = DB::table('viajes')->insertGetId([
            'empresa_id' => $empresa2Id,
            'ruta_id' => $ruta2Id,
            'unidad_id' => $coaster1Id,
            'motorista_id' => $motorista2Id,
            'fecha' => Carbon::today()->format('Y-m-d'),
            'hora_salida' => '08:00',
            'estado' => 'en_ruta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // -----------------------
        // Puntos de Control
        // -----------------------
        DB::table('puntos_control')->insert([
            [
                'viaje_id' => $viaje1Id,
                'motorista_id' => $motorista1Id,
                'tipo' => 'entrada',
                'latitud' => 13.6929,
                'longitud' => -89.2182,
                'hora_reporte' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'viaje_id' => $viaje1Id,
                'motorista_id' => $motorista1Id,
                'tipo' => 'salida',
                'latitud' => 13.6925,
                'longitud' => -89.2300,
                'hora_reporte' => Carbon::now()->addMinutes(20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'viaje_id' => $viaje2Id,
                'motorista_id' => $motorista2Id,
                'tipo' => 'entrada',
                'latitud' => 13.9940,
                'longitud' => -89.5590,
                'hora_reporte' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'viaje_id' => $viaje2Id,
                'motorista_id' => $motorista2Id,
                'tipo' => 'salida',
                'latitud' => 13.9800,
                'longitud' => -89.5700,
                'hora_reporte' => Carbon::now()->addMinutes(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
