<?php

namespace App\Http\Controllers;

use App\Models\CropProductionRecord;
use App\Models\CropRevenueRecord;
use App\Models\LivestockProductionRecord;
use App\Models\LivestockRevenueRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            ->get()
            ->groupBy('crop_name');
        if (!$crop_production) {
            return response()->json(['message' => 'No records found'], 404);
        }
        $crop_revenue = CropRevenueRecord::where('country', $request->country)
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->get()
            ->groupBy('crop_name');
        if (!$crop_revenue) {
            return response()->json(['message' => 'No records found'], 404);
        }

        $response = [];
        foreach ($crop_production as $crop_name => $records) {
            $total_storage_in_ton = $records->sum('storage_qty') ?? 0;

            $total_storage_in_kg = $total_storage_in_ton * 1000;

            $total_sale = isset($crop_revenue[$crop_name])
            ? ($crop_revenue[$crop_name]->sum('cash_sale_qty') ?? 0) +
            ($crop_revenue[$crop_name]->sum('credit_sale_qty') ?? 0)
            : 0;
            $total_revenue = isset($crop_revenue[$crop_name])
            ? ($crop_revenue[$crop_name]->sum('cash_sale_price') ?? 0) +
            ($crop_revenue[$crop_name]->sum('credit_sale_price') ?? 0)
            : 0;

            $average_market_price = $total_sale > 0 ? $total_revenue / $total_sale : 0;

            $response[] = [
                'crop_name' => $crop_name,
                'average_market_price' => number_format($average_market_price, 2),
                'total_storage_in_ton' => number_format($total_storage_in_ton, 2),
                'total_storage_in_kg' => number_format($total_storage_in_kg, 2),
            ];
        }

        return response()->json([
            'message' => 'success',
            'data' => $response,
        ]);
    }

    public function getRealMarketProductionLivestock(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error', $validate->errors()], 422);
        }
        $crop_production = LivestockProductionRecord::where('country', $request->country)
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->get()
            ->groupBy('crop_name');
        if (!$crop_production) {
            return response()->json(['message' => 'No records found'], 404);
        }
        $crop_revenue = LivestockRevenueRecord::where('country', $request->country)
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->get()
            ->groupBy('crop_name');
        if (!$crop_revenue) {
            return response()->json(['message' => 'No records found'], 404);
        }

        $response = [];
        foreach ($crop_production as $crop_name => $records) {
            $total_storage_in_ton = $records->sum('storage_qty') ?? 0;

            $total_storage_in_kg = $total_storage_in_ton * 1000;

            $total_sale = isset($crop_revenue[$crop_name])
            ? ($crop_revenue[$crop_name]->sum('cash_sale_qty') ?? 0) +
            ($crop_revenue[$crop_name]->sum('credit_sale_qty') ?? 0)
            : 0;
            $total_revenue = isset($crop_revenue[$crop_name])
            ? ($crop_revenue[$crop_name]->sum('cash_sale_price') ?? 0) +
            ($crop_revenue[$crop_name]->sum('credit_sale_price') ?? 0)
            : 0;

            $average_market_price = $total_sale > 0 ? $total_revenue / $total_sale : 0;

            $response[] = [
                'crop_name' => $crop_name,
                'average_market_price' => number_format($average_market_price, 2),
                'total_storage_in_ton' => number_format($total_storage_in_ton, 2),
                'total_storage_in_kg' => number_format($total_storage_in_kg, 2),
            ];
        }

        return response()->json([
            'message' => 'success',
            'data' => $response,
        ]);
    }

    public function getlastsixmonthProductionReport(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country' => 'required',
            'crop' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error', $validate->errors()], 422);
        }
        $report_production = CropProductionRecord::where('country', $request->country)
            ->where('crop_name', $request->crop)
            ->whereBetween('created_at', [now()->subMonths(6), now()])
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('M');
            });
        $report_revenue = CropRevenueRecord::where('country', $request->country)
            ->where('crop_name', $request->crop)
            ->whereBetween('created_at', [now()->subMonths(6), now()])
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('M');
            });

        $report = [];
        foreach ($report_production as $month => $productionRecords) {
            $revenueRecords = $report_revenue[$month] ?? collect();

            $total_storage_in_ton = $productionRecords->sum('storage_qty') ?? 0;
            $total_storage_in_kg = $total_storage_in_ton * 1000;
            $total_sale = ($revenueRecords->sum('cash_sale_price') ?? 0) + ($revenueRecords->sum('credit_sale_price') ?? 0);
            $total_sale_qty = ($revenueRecords->sum('cash_sale_qty') ?? 0) + ($revenueRecords->sum('credit_sale_qty') ?? 0);
            $total_farmer = $productionRecords->sum('labour_qty') ?? 0;

            $total_cost = ($productionRecords->sum('ploughing_price') ?? 0) + ($productionRecords->sum('seed_price') ?? 0) +
            ($productionRecords->sum('fertilizer_price') ?? 0) + ($productionRecords->sum('herbicides_price') ?? 0) +
            ($productionRecords->sum('pesticide_price') ?? 0) + ($productionRecords->sum('labour_price') ?? 0) +
            ($productionRecords->sum('packaing_price') ?? 0) + ($productionRecords->sum('transport_price') ?? 0) +
            ($productionRecords->sum('variety_price') ?? 0) + ($productionRecords->sum('equipment_price') ?? 0) +
            ($productionRecords->sum('land_size_price') ?? 0);

            $price_per_kr = $total_storage_in_kg != 0 ? $total_sale / $total_sale_qty : 0;

            $cost_per_kg = $total_cost != 0 ? $total_cost / $total_storage_in_kg : 0;

            $report[$month] = [
                'month' => $month,
                'total_production' => number_format($total_storage_in_ton, 2),
                'total_revenue' => number_format($total_sale, 2),
                'input' => $total_cost,
                'price_per_kg' => number_format($price_per_kr, 4),
                'cost_per_kg' => number_format($cost_per_kg, 4),
                'farmer' => $total_farmer,
                'total_cost' => $total_cost,

            ];
        }
        return response()->json([
            'message' => 'success',
            'data' => $report,
        ]);
    }

    public function getlastsixmonthLivestockReport(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'country' => 'required',
            'crop' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error', $validate->errors()], 422);
        }
        $report_production = LivestockProductionRecord::where('country', $request->country)
            ->where('crop_name', $request->crop)
            ->whereBetween('created_at', [now()->subMonths(6), now()])
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('M');
            });
        $report_revenue = LivestockRevenueRecord::where('country', $request->country)
            ->where('crop_name', $request->crop)
            ->whereBetween('created_at', [now()->subMonths(6), now()])
            ->get()
            ->groupBy(function ($date) {
                return $date->created_at->format('M');
            });

        $report = [];
        foreach ($report_production as $month => $productionRecords) {
            $revenueRecords = $report_revenue[$month] ?? collect();

            $total_storage_in_ton = $productionRecords->sum('storage_qty') ?? 0;
            $total_storage_in_kg = $total_storage_in_ton * 1000;
            $total_sale = ($revenueRecords->sum('cash_sale_price') ?? 0) + ($revenueRecords->sum('credit_sale_price') ?? 0);
            $total_sale_qty = ($revenueRecords->sum('cash_sale_qty') ?? 0) + ($revenueRecords->sum('credit_sale_qty') ?? 0);
            $total_farmer = $productionRecords->sum('labour_qty') ?? 0;

            $total_cost = ($productionRecords->sum('equipment_price') ?? 0) + ($productionRecords->sum('seed_price') ?? 0) +
            ($productionRecords->sum('feeds_price') ?? 0) + ($productionRecords->sum('suppliements_price') ?? 0) +
            ($productionRecords->sum('pesticide_price') ?? 0) + ($productionRecords->sum('labour_price') ?? 0) +
            ($productionRecords->sum('packaing_price') ?? 0) + ($productionRecords->sum('storage_price') ?? 0) +
            ($productionRecords->sum('transport_price') ?? 0) + ($productionRecords->sum('spray_price') ?? 0) +
            ($productionRecords->sum('variety_price') ?? 0) + ($productionRecords->sum('tool_price') ?? 0) +
            ($productionRecords->sum('model_price') ?? 0) + ($productionRecords->sum('range_price') ?? 0) +
            ($productionRecords->sum('land_size_price') ?? 0);

            $price_per_kr = $total_storage_in_kg != 0 ? $total_sale / $total_sale_qty : 0;

            $cost_per_kg = $total_cost != 0 ? $total_cost / $total_storage_in_kg : 0;

            $report[$month] = [
                'month' => $month,
                'total_production' => number_format($total_storage_in_ton, 2),
                'total_revenue' => number_format($total_sale, 2),
                'input' => $total_cost,
                'price_per_kg' => number_format($price_per_kr, 4),
                'cost_per_kg' => number_format($cost_per_kg, 4),
                'farmer' => $total_farmer,
                'total_cost' => $total_cost,

            ];
        }
        return response()->json([
            'message' => 'success',
            'data' => $report,
        ]);
    }
}
