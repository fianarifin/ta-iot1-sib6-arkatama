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
}
