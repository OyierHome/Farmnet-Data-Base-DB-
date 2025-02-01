<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function show(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'city' => 'required|string',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        $city = $request->input('city', $request->city); // Default city
        $weatherData = $this->weatherService->getWeather($city);

        return response()->json([
            'status' => 'success',
            'data' => $weatherData
        ],
    201);
    }
}
