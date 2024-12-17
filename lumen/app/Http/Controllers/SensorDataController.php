<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData; // Importa el modelo

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
        // Validar que los datos estén presentes y sean numéricos
        $this->validate($request, [
            'humedad' => 'required|numeric',
            'temperatura' => 'required|numeric',
        ]);

        // Crear el registro en la base de datos usando el modelo
        $sensorData = SensorData::create([
            'humedad' => $request->input('humedad'),
            'temperatura' => $request->input('temperatura'),
        ]);

        // Devolver una respuesta JSON de confirmación
        return response()->json([
            'status' => 'success',
            'data' => $sensorData
        ]);
    }

    public function index()
    {
        // Obtener todos los registros de la base de datos
        $sensorData = SensorData::all();

        // Devolver la lista de registros
        return response()->json($sensorData);
    }
}
