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
            ->where('created_at', '>=', $request->year . '-' . $request->month . '-01')
            ->where('created_at', '<=', $request->year . '-' . $request->month . '-31')
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
            ->where('created_at', '>=', $request->year . '-' . $request->month . '-01')
            ->where('created_at', '<=', $request->year . '-' . $request->month . '-31')
            ->get();
        if (!$records) {
            return response()->json(['message' => 'No records found'], 404);
        }
        return response()->json(['message' => 'success', 'data' => $records]);
    }
}
