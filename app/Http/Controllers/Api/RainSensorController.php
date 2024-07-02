<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RainSensor;
use App\Service\WhatsappNotificationService;

class RainSensorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric',
        ]);

        $sensorData = RainSensor::create($request->all());

        // Trigger notification if the sensor value exceeds the threshold
        if ($sensorData->value > 700) {
            WhatsappNotificationService::notifikasiHujanLebatMassal($sensorData->value);
        }

        return response()->json($sensorData, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'value' => 'required|numeric',
        ]);

        $sensorData = RainSensor::find($id);

        if (!$sensorData) {
            return response()->json(['message' => 'Data not found'], 400);
        }

        $sensorData->update($request->all());

        // Trigger notification if the sensor value exceeds the threshold
        if ($sensorData->value > 700) {
            WhatsappNotificationService::notifikasiHujanLebatMassal($sensorData->value);
        }

        return response()->json($sensorData, 200);
    }

    public function destroy($id)
    {
        $sensorData = RainSensor::find($id);

        if (!$sensorData) {
            return response()->json(['message' => 'Data not found'], 400);
        }

        $sensorData->delete();

        return response()->json(['message' => 'Sensor data deleted successfully'], 200);
    }

    public function show($id)
    {
        $sensorData = RainSensor::find($id);

        if ($sensorData) {
            return response()->json($sensorData, 200);
        } else {
            return response()->json(['message' => 'Data not found'], 400);
        }
    }

    public function index()
    {
        $sensorsData = RainSensor::limit(20)->get();

        return response()->json([
            'data' => $sensorsData,
            'message' => 'Success',
        ], 200);
    }
}
