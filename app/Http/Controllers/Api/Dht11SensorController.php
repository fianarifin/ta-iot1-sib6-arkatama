<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dht11Sensor;
use Illuminate\Http\Request;

class Dht11SensorController extends Controller
{
    public function index()
    {
        $sensorsData = Dht11Sensor::orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()
            ->json([
                'data' => $sensorsData,
                'message' => 'Success',
            ], 200);
    }

    public function show($id)
    {
        $sensorData = Dht11Sensor::find($id);
        if ($sensorData) {
            return response()
                ->json($sensorData, 200);
        } else {
            return response()
                ->json(['message' => 'Data not found'], 400);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'humidity' => 'required|numeric',
            'temperature' => 'required|numeric',
        ]);

        $sensorData = Dht11Sensor::create($request->all());

        return response()
            ->json($sensorData, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'humidity' => 'required|numeric',
            'temperature' => 'required|numeric',
        ]);

        $sensorData = Dht11Sensor::find($id);
        if (!$sensorData) {
            return response()
                ->json(['message' => 'Data not found'], 400);
        }

        $sensorData->update($request->all());

        return response()
            ->json($sensorData, 200);
    }

    public function destroy($id)
    {
        $sensorData = Dht11Sensor::find($id);
        if (!$sensorData) {
            return response()
                ->json(['message' => 'Data not found'], 400);
        }

        $sensorData->delete();

        return response()
            ->json(['message' => 'Sensor data deleted successfully'], 200);
    }
}
