<?php

use App\Http\Controllers\AddBookingController;
use App\Http\Controllers\Api\AdvertisementController;
use App\Http\Controllers\Api\CropRecordController;
use App\Http\Controllers\Api\Enterprise\CropController;
use App\Http\Controllers\Api\EnterpriseController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\LivestockController;
use App\Http\Controllers\MarketOverview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user()->with('organization')->first();
})->middleware('auth:sanctum');
Route::post('/user/create', [UserController::class, 'store_user']);
Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/verify', [UserController::class, 'verifyUser']);
Route::post('/user/verify/resend', [UserController::class, 'resendVerificationCode']);
Route::post('/user/forget/password', [UserController::class, 'forgetPassword']);
Route::post('/user/forget/password/verify', [UserController::class, 'forgetPasswordVerify']);
Route::post('/user/get/uniqueID', [UserController::class, 'getUserByUniqueID']);


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
Route::post('/market/overview/livestock', [MarketOverview::class, 'getRealMarketProductionLivestock']);
Route::post('/market/production/lastSixMonth', [MarketOverview::class, 'getLastSixMonthProductionReport']);
Route::post('/market/livestock/lastSixMonth', [MarketOverview::class, 'getLastSixMonthLivestockReport']);
Route::post('/market/overview/home', [MarketOverview::class, 'getRealMarketProduction']);
Route::post('/market/overview/user', [MarketOverview::class, 'getUsersMarketProduction']);

// LiveStock Records routes

Route::post('/livestock/create/production', [LivestockController::class, 'livestock_production_record']);
Route::post('/livestock/create/revenue', [LivestockController::class, 'livestock_revenue_record']);
Route::post('/livestock/create/inventory', [LivestockController::class, 'livestock_inventory_record']);


// Advertisement Routes
Route::get('/advertisement/{id}', [AdvertisementController::class, 'index']);
Route::post('/advertisement/create', [AdvertisementController::class, 'store_add']);
Route::post('/advertisement/update/{id}', [AdvertisementController::class, 'edit_advertisement']);
Route::get('/advertisement/show/{id}', [AdvertisementController::class, 'show']);


//Book Advertisiment
Route::post('/advertisement/book/create', [AddBookingController::class, 'store_booking']);
Route::post('/advertisement/book/index', [AddBookingController::class, 'index']);
Route::post('/advertisement/book/check', [AddBookingController::class, 'check_aveliable']);


// Enterprise Routes
Route::post('/enterprise/crop/create/production', [CropController::class, 'create_production']);
Route::post('/enterprise/crop/create/revenue', [CropController::class, 'create_revenue']);

Route::post('/enterprise/livestock/create/production', [\App\Http\Controllers\Api\Enterprise\LivestockController::class, 'create_production']);
Route::post('/enterprise/livestock/create/revenue', [\App\Http\Controllers\Api\Enterprise\LivestockController::class, 'create_revenue']);


// Enterprise Routes
Route::post('/enterprise/create/test', [EnterpriseController::class, 'create_testing']);
Route::post('/enterprise/create/bill', [EnterpriseController::class, 'create_bill']);
Route::post('/enterprise/create/statement', [EnterpriseController::class, 'create_statement']);
Route::post('/enterprise/create/food/certificate', [EnterpriseController::class, 'create_food_certificate']);
Route::post('/enterprise/create/plan', [EnterpriseController::class, 'create_plan']);
Route::post('/enterprise/create/tak', [EnterpriseController::class, 'create_task']);

Route::post('/enterprise/create/fund_insurance', [EnterpriseController::class, 'request_fund_insurance']);
Route::post('/enterprise/create/review', [EnterpriseController::class, 'Rate_review']);
Route::post('/enterprise/create/reward', [EnterpriseController::class, 'add_rewards']);

Route::post('/enterprise/crop/production', [EnterpriseController::class, 'crop_report_production']);
Route::post('/enterprise/crop/revenue', [EnterpriseController::class, 'crop_report_revenue']);
Route::post('/enterprise/crop/inventory', [EnterpriseController::class, 'crop_report_inventory']);

Route::post('/enterprise/livestock/production', [EnterpriseController::class, 'livestock_report_production']);
Route::post('/enterprise/livestock/revenue', [EnterpriseController::class, 'livestock_report_revenue']);
Route::post('/enterprise/livestock/inventory', [EnterpriseController::class, 'livestock_report_inventory']);

//Enterprise Invoice Crop Inventory

Route::post('/enterprise/crop/inventory/get', [EnterpriseController::class, 'getInventory']);
//Enterprise Money In Out
Route::post('/enterprise/money/in/out', [EnterpriseController::class, 'monetInOut']);
Route::post('/enterprise/bill', [EnterpriseController::class, 'getBillById']);

// Profile routes
Route::post('/profile/create', [ProfileController::class, 'create_or_update']);
Route::post('/profile/certificate', [ProfileController::class, 'add_certificate']);


//Settings Routes
Route::post('settings/update/uses', [SettingController::class, 'upDateUsers']);
Route::post('settings/create/update', [SettingController::class, 'create_updateSetting']);
