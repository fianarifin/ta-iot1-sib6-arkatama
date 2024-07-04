<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RainSensor;

class RainSensorController extends Controller
{
    public function index()
    {
        $rainData = RainSensor::latest()->first();
        return response()->json(['data' => [$rainData]]);
    }

    public function show($id)
    {
        $rainData = RainSensor::findOrFail($id);
        return response()->json(['data' => [$rainData]]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric'
        ]);

        $rainData = RainSensor::create([
            'value' => $request->value
        ]);

        return response()->json(['data' => $rainData], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'value' => 'required|numeric'
        ]);

        $rainData = RainSensor::findOrFail($id);
        $rainData->update([
            'value' => $request->value
        ]);

        return response()->json(['data' => $rainData]);
    }

    public function destroy($id)
    {
        $rainData = RainSensor::findOrFail($id);
        $rainData->delete();

        return response()->json(null, 204);
    }
}
