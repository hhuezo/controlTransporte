<?php

namespace App\Http\Controllers;

use App\Models\PuntoControl;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControlViajeController extends Controller
{
    public function index(Request $request)
    {
        $motoristas = User::whereHas('roles', function ($query) {
            $query->where('id', 2);
        })->get();

        return view('administracion.index', compact('motoristas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $control = new PuntoControl();

        $control->motorista_id = $request->motorista_id;
        $control->tipo = $request->tipo; // 'entrada', 'salida', etc.
        $control->latitud = $request->latitud;
        $control->longitud = $request->longitud;
        $control->hora_reporte = $request->hora_reporte ?? Carbon::now();

        $control->save();

        return response()->json([
            'success' => true,
            'message' => 'Punto de control registrado correctamente.',
            'data' => $control
        ]);
    }


    public function show(Request $request, string $id)
    {
        $motorista = User::findOrFail($id);

        // Verificar fechas enviadas o usar por defecto
        $fechaInicio = $request->input('fecha_inicio')
            ? Carbon::parse($request->input('fecha_inicio'))->startOfDay()
            : Carbon::today()->startOfDay();

        $fechaFin = $request->input('fecha_fin')
            ? Carbon::parse($request->input('fecha_fin'))->endOfDay()
            : Carbon::today()->endOfDay();

        // Verificar horas o usar por defecto
        $horaInicio = $request->input('hora_inicio') ?? '04:00';
        $horaFin = $request->input('hora_fin') ?? '20:00';

        // Combinar fechas y horas en formato datetime
        $inicio = Carbon::parse($fechaInicio->format('Y-m-d') . ' ' . $horaInicio);
        $fin = Carbon::parse($fechaFin->format('Y-m-d') . ' ' . $horaFin);

        // Obtener puntos de control dentro del rango
        $puntos = $motorista->puntos_control()
            ->whereBetween('hora_reporte', [$inicio, $fin])
            ->orderBy('hora_reporte', 'asc')
            ->get();

        return view('administracion.show', compact('motorista', 'puntos', 'fechaInicio', 'fechaFin', 'horaInicio', 'horaFin'));
    }


    public function get_data_control(string $id)
    {
        //$hoy = Carbon::tomorrow();
        $hoy = Carbon::today();

        $control = PuntoControl::where('motorista_id', $id)
            ->whereDate('hora_reporte', $hoy)
            ->orderBy('hora_reporte', 'desc')
            ->first();

        $tipo = $control ? $control->tipo : 'entrada';

        return response()->json([
            'motorista_id' => $id,
            'tipo' => $tipo,
            'fecha_consulta' => $hoy->format('Y-m-d'),
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
