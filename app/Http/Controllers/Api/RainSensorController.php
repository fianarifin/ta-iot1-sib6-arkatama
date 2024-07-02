<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RainSensor;
use Illuminate\Http\Request;
use App\Service\WhatsappNotificationService;
use App\Models\SentMessage;

class RainSensorController extends Controller
{
    public function index()
    {
        $sensorsData = RainSensor::orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'data' => $sensorsData,
            'message' => 'Success',
        ], 200);
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

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric',
        ]);

        $sensorData = RainSensor::create($request->all());

        // Cek nilai sensor dan kirim notifikasi jika lebih dari 700
        if ($sensorData->value > 700) {
            // Mengirim notifikasi untuk semua admin
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
}
