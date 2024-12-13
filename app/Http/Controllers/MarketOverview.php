<?php

namespace App\Http\Controllers;

use App\Models\CropProductionRecord;
use App\Models\CropRevenueRecord;
use Illuminate\Http\Request;

class MarketOverview extends Controller
{
    public function getMarketProductionMonthly(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'month' => 'required',
            'year' => 'required',
            'country' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error', $validate->errors()], 422);
        }

        $records = CropProductionRecord::where('country', $request->country)
            ->whereYear('created_at', $request->year)
            ->whereMonth('created_at', $request->month)
            ->get();
        if (!$records) {
            return response()->json(['message' => 'No records found'], 404);
        }
        return response()->json(['message' => 'success', 'data' => $records]);

    }
    public function getRevenueProductionMonthly(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'month' => 'required',
            'year' => 'required',
            'country' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error', $validate->errors()], 422);
        }
        $records = CropRevenueRecord::where('country', $request->country)
            ->whereYear('created_at', $request->year)
            ->whereMonth('created_at', $request->year)
            ->get();
        if (!$records) {
            return response()->json(['message' => 'No records found'], 404);
        }
        return response()->json(['message' => 'success', 'data' => $records]);
    }

    public function getMarketProductionYearly(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'year' => 'required',
            'country' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error', $validate->errors()], 422);
        }
        $records = CropProductionRecord::where('country', $request->country)
            ->whereYear('created_at', $request->year)
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('m');
            });
        if (!$records) {
            return response()->json(['message' => 'No records found'], 404);
        }
        $response = [];
        foreach ($records as $key => $record) {
            $response[$key] = $record->sum([
                'production', 'ploughing_qty', 'ploughing_price', 'seed_qty', 'seed_price', 'fertilizer_qty', 'fertilizer_price', 'herbicides_qty', 'herbicides_price', 'pesticide_qty', 'pesticide_price', 'labour_qty', 'labour_price', 'packaing_qty', 'packaing_price', 'storage_qty', 'storage_price', 'transport_qty', 'transport_price', 'variety_qty', 'variety_price', 'equipment_qty', 'equipment_price', 'land_size_qty', 'land_size_price',
            ]);
        }
        return response()->json(['message' => 'success', 'data' => $response]);

    }
    public function getMarketRevenueYearly(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'year' => 'required',
            'country' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error', $validate->errors()], 422);
        }
        $records = CropRevenueRecord::where('country', $request->country)
            ->whereYear('created_at', $request->year)
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('m');
            });
        if (!$records) {
            return response()->json(['message' => 'No records found'], 404);
        }
        $response = [];
        foreach ($records as $key => $record) {
            $response[$key] = $record->sum([
                'cash_sale_qty', 'credit_sale_qty', 'services_qty', 'advertisiment_qty',
                'donation_qty', 'farm_visit_qty', 'royality_qty', 'incentives_qty',
                'bonuses_qty', 'research_qty', 'traning_qty', 'land_size_qty',
                'cash_sale_price', 'credit_sale_price', 'services_price', 'advertisiment_price',
                'donation_price', 'farm_visit_price', 'royality_price', 'incentives_price',
                'bonuses_price', 'research_price', 'traning_price', 'land_size_price',
            ]);
        }
        return response()->json(['message' => 'success', 'data' => $response]);

    }

    public function getRealMarketProduction(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error', $validate->errors()], 422);
        }
        $crop_production = CropProductionRecord::where('country', $request->country)
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->get();
        if (!$crop_production) {
            return response()->json(['message' => 'No records found'], 404);
        }
        $crop_revenue = CropRevenueRecord::where('country', $request->country)
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->get();
        if (!$crop_revenue) {
            return response()->json(['message' => 'No records found'], 404);
        }

        $total_storage_in_ton = $crop_production->sum('storage_qty');

        $total_storage_in_kg = $total_storage_in_ton * 1000;

        $total_sale = $crop_revenue->sum('cash_sale_price') + $crop_revenue->sum('credit_sale_price');

        $average_market_price = $total_sale != 0 ? $total_storage_in_kg / $total_sale : 0;

        return response()->json([
            'message' => 'success',
            'data' => [
                'average_market_price' => number_format($average_market_price, 2),
                'total_storage_in_kg' => $total_storage_in_kg,
            ],
        ]);
    }

}
