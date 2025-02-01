<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.openweather.api_key');

        $this->baseUrl = "https://api.openweathermap.org/data/2.5/weather";
    }

    public function getWeather($city)
    {

        $response = Http::get($this->baseUrl, [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric' // 'imperial' for Fahrenheit
        ]);
        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => 'Unable to fetch weather data.'];
    }
}
