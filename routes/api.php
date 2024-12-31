<?php

use App\Http\Controllers\Api\CropRecordController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\LivestockController;
use App\Http\Controllers\Api\MarketOverviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user()->with('organization')->first();
})->middleware('auth:sanctum');
Route::post('/user/create', [UserController::class, 'store_user']);
Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/verify', [UserController::class, 'verifyUser']);

// Crop Record Routes
Route::post('/crop/create/revenue', [CropRecordController::class, 'create_revenue_record']);
Route::post('/crop/create/production', [CropRecordController::class, 'create_production_record']);
Route::post('/crop/create/inventory', [CropRecordController::class, 'create_inventory_record']);
Route::post('/crop/production/user', [CropRecordController::class, 'getProductionRecordOfSingleUser']);
Route::post('/crop/revenue/user', [CropRecordController::class, 'getRevenueRecordOfSingleUser']);
Route::post('/crop/production/month', [CropRecordController::class, 'getProductionRecordOfSingleMonth']);
Route::post('/crop/revenue/month', [CropRecordController::class, 'getRevenueRecordOfSingleMonth']);
Route::post('/crop/production/year', [CropRecordController::class, 'getProductionRecordOfSingleYear']);
Route::post('/crop/revenue/year', [CropRecordController::class, 'getRevenueRecordOfSingleYear']);
Route::get('/crop/production', [CropRecordController::class, 'get_crop_production_record']);
Route::get('/crop/revenue', [CropRecordController::class, 'get_crop_revenue_record']);

//Market record
Route::post('/market/production/month', [MarketOverview::class, 'getMarketProductionMonthly']);
Route::post('/market/revenue/month', [MarketOverview::class, 'getRevenueProductionMonthly']);
Route::post('/market/overview/home', [MarketOverview::class, 'getRealMarketProduction']);
Route::post('/market/overview/livestock', [MarketOverview::class, 'getRealMarketProductionLivestock']);
Route::post('/market/production/lastSixMonth', [MarketOverviewController::class, 'getLastSixMonthProductionReport']);
Route::post('/market/livestock/lastSixMonth', [MarketOverviewController::class, 'getLastSixMonthLivestockReport']);

// LiveStock Records routes

Route::post('/livestock/create/production', [LivestockController::class, 'livestock_production_record']);
Route::post('/livestock/create/revenue', [LivestockController::class, 'livestock_revenue_record']);
Route::post('/livestock/create/inventory', [LivestockController::class, 'livestock_inventory_record']);
