<?php

namespace App\Http\Controllers;

use App\Models\LivestockInventory;
use App\Models\LivestockProductionRecord;
use App\Models\LivestockRevenueRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LivestockController extends Controller
{

    public function livestock_production_record(Request $request)
    {
        //Validate the Data
        // Starting Transaction
        //Create new Date
        //create new record
        //End Transaction
        //return response

        try {
            $validate = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'crop_name' => 'required',
                'country' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['error' => $validate->errors()], 422);
            }

            DB::beginTransaction();

            // new record
            $record = LivestockProductionRecord::create([
                'user_id' => $request->user_id,
                'crop_name' => $request->crop_name,
                'country' => $request->country,
                'equipment_qty' => $request->equipment_qty,
                'equipment_price' => $request->equipment_price,
                'seed_qty' => $request->seed_qty,
                'seed_price' => $request->seed_price,
                'feeds_qty' => $request->feeds_qty,
                'feeds_price' => $request->feeds_price,
                'suppliements_qty' => $request->suppliements_qty,
                'suppliements_price' => $request->suppliements_price,
                'pesticide_qty' => $request->pesticide_qty,
                'pesticide_price' => $request->pesticide_price,
                'labour_qty' => $request->labour_qty,
                'labour_price' => $request->labour_price,
                'packaing_qty' => $request->packaing_qty,
                'packaing_price' => $request->packaing_price,
                'storage_qty' => $request->storage_qty,
                'storage_price' => $request->storage_price,
                'transport_qty' => $request->transport_qty,
                'transport_price' => $request->transport_price,
                'spray_qty' => $request->spray_qty,
                'spray_price' => $request->spray_price,
                'variety_qty' => $request->variety_qty,
                'variety_price' => $request->variety_price,
                'tool_qty' => $request->tool_qty,
                'tool_price' => $request->tool_price,
                'model_qty' => $request->model_qty,
                'model_price' => $request->model_price,
                'range_qty' => $request->range_qty,
                'range_price' => $request->range_price,
                'land_size_qty' => $request->land_size_qty,
                'land_size_price' => $request->land_size_price,
            ]);
            DB::commit();
            return response()->json(
                ['message' => 'Record created successfully',
                    'data' => $record,
                ], 201, []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function livestock_revenue_record(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'crop_name' => 'required',
                'country' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['error' => $validate->errors()], 422);
            }

            DB::beginTransaction();

            $record = LivestockRevenueRecord::create([
                'user_id' => $request->user_id,
                'crop_name' => $request->crop_name,
                'country' => $request->country,
                'cash_sale_qty' => $request->cash_sale_qty,
                'cash_sale_price' => $request->cash_sale_price,
                'credit_sale_qty' => $request->credit_sale_qty,
                'credit_sale_price' => $request->credit_sale_price,
                'services_qty' => $request->services_qty,
                'services_price' => $request->services_price,
                'advertisiment_qty' => $request->advertisiment_qty,
                'advertisiment_price' => $request->advertisiment_price,
                'donation_qty' => $request->donation_qty,
                'donation_price' => $request->donation_price,
                'farm_visit_qty' => $request->farm_visit_qty,
                'farm_visit_price' => $request->farm_visit_price,
                'royality_qty' => $request->royality_qty,
                'royality_price' => $request->royality_price,
                'incentives_qty' => $request->incentives_qty,
                'incentives_price' => $request->incentives_price,
                'bonuses_qty' => $request->bonuses_qty,
                'bonuses_price' => $request->bonuses_price,
                'research_qty' => $request->research_qty,
                'research_price' => $request->research_price,
                'traning_qty' => $request->traning_qty,
                'traning_price' => $request->traning_price,
                'hospitality_qty' => $request->hospitality_qty,
                'hospitality_price' => $request->hospitality_price,
                'intrests_qty' => $request->intrests_qty,
                'intrests_price' => $request->intrests_price,
                'land_size_qty' => $request->land_size_qty,
                'land_size_price' => $request->land_size_price,
            ]);

            DB::commit();
            return response()->json(
                ['message' => 'Record created successfully',
                    'data' => $record,
                ], 201, []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function livestock_inventory_record(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'crop_name' => 'required',
                'country' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['error' => $validate->errors()], 422);
            }

            DB::beginTransaction();

            $record = LivestockInventory::create([
                'user_id' => $request->user_id,
                'crop_name' => $request->crop_name,
                'country' => $request->country,
                'ploughing_qty' => $request->ploughing_qty,
                'ploughing_price' => $request->ploughing_price,
                'seed_qty' => $request->seed_qty,
                'seed_price' => $request->seed_price,
                'fertilizer_qty' => $request->fertilizer_qty,
                'fertilizer_price' => $request->fertilizer_price,
                'herbicide_qty' => $request->herbicide_qty,
                'herbicide_price' => $request->herbicide_price,
                'pesticide_qty' => $request->pesticide_qty,
                'pesticide_price' => $request->pesticide_price,
                'labour_qty' => $request->labour_qty,
                'labour_price' => $request->labour_price,
                'packaing_qty' => $request->packaing_qty,
                'packaing_price' => $request->packaing_price,
                'storage_qty' => $request->storage_qty,
                'storage_price' => $request->storage_price,
                'transport_qty' => $request->transport_qty,
                'transport_price' => $request->transport_price,
                'trees_price' => $request->trees_price,
                'equipment_qty' => $request->equipment_qty,
                'equipment_price' => $request->equipment_price,
                'tools_qty' => $request->tools_qty,
                'tools_price' => $request->tools_price,
                'feeders_qty' => $request->feeders_qty,
                'feeders_price' => $request->feeders_price,
                'land_size_qty' => $request->land_size_qty,
                'land_size_price' => $request->land_size_price,
            ]);

            DB::commit();
            return response()->json(
                ['message' => 'Record created successfully',
                    'data' => $record,
                ], 201, []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

}
