<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Models\CropInventory;
use App\Models\CropProductionRecord;
use App\Models\CropRevenueRecord;
use Illuminate\Http\Request;
=======
use App\Models\CropProductionRecord;
use App\Models\CropRevenueRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
use Illuminate\Support\Facades\Validator;

class CropRecordController extends Controller
{

    public function getProductionRecordOfSingleUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        $records = CropProductionRecord::where('user_id', $request->user_id)
            ->get();
        if (!$records) {
            return response()->json(['message' => 'No records found'], 404);
        }
        return response()->json(['message' => 'success', 'data' => $records]);
    }

    public function getRevenueRecordOfSingleUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        $records = CropRevenueRecord::where('user_id', $request->user_id)
            ->get();
        if (!$records) {
            return response()->json(['message' => 'No records found'], 404);
        }
        return response()->json(['message' => 'success', 'data' => $records]);
    }

    public function getRevenueRecordOfSingleMonth(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'month' => 'required|numeric',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        $records = CropRevenueRecord::where('user_id', $request->user_id)
            ->whereMonth('created_at', $request->month)
            ->get();
        if (!$records) {
            return response()->json(['message' => 'No records found'], 404);
        }
        return response()->json(['message' => 'success', 'data' => $records]);
    }

    public function getProductionRecordOfSingleMonth(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'month' => 'required|numeric',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        $records = CropProductionRecord::where('user_id', $request->user_id)
            ->whereMonth('created_at', $request->month)
            ->get();
        if (!$records) {
            return response()->json(['message' => 'No records found'], 404);
        }
        return response()->json(['message' => 'success', 'data' => $records]);
    }

    public function getRevenueRecordOfSingleYear(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'year' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        $record = CropRevenueRecord::where('user_id', $request->user_id)
            ->whereYear('created_at', $request->year)
            ->get();
        if (!$record) {
            return response()->json(['message' => 'No records found'], 404);
        }
        return response()->json(['message' => 'success', 'data' => $record]);

    }

    public function getProductionRecordOfSingleYear(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'year' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        $record = CropProductionRecord::where('user_id', $request->user_id)
            ->whereYear('created_at', $request->year)
            ->get();
        if (!$record) {
            return response()->json(['message' => 'No records found'], 404);
        }
        return response()->json(['message' => 'success', 'data' => $record]);
    }

    public function create_revenue_record(Request $request)
    {

        //Validate the Data
        // Starting Transaction
        //Create new Date
        //create new record
        //End Transaction
        //return response

<<<<<<< HEAD
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop_name' => 'required',
            'country' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        // new record
        $record = new CropRevenueRecord();
        $record->user_id = $request->user_id;
        $record->crop_name = $request->crop_name;
        $record->country = $request->country;
        $record->cash_sale_qty = $request->cash_sale_qty;
        $record->cash_sale_price = $request->cash_sale_price;
        $record->credit_sale_qty = $request->credit_sale_qty;
        $record->credit_sale_price = $request->credit_sale_price;
        $record->services_qty = $request->services_qty;
        $record->services_price = $request->services_price;
        $record->advertisiment_qty = $request->advertisiment_qty;
        $record->advertisiment_price = $request->advertisiment_price;
        $record->donation_qty = $request->donation_qty;
        $record->donation_price = $request->donation_price;
        $record->farm_visit_qty = $request->farm_visit_qty;
        $record->farm_visit_price = $request->farm_visit_price;
        $record->royality_qty = $request->royality_qty;
        $record->royality_price = $request->royality_price;
        $record->incentives_qty = $request->incentives_qty;
        $record->incentives_price = $request->incentives_price;
        $record->bonuses_qty = $request->bonuses_qty;
        $record->bonuses_price = $request->bonuses_price;
        $record->research_qty = $request->research_qty;
        $record->research_price = $request->research_price;
        $record->traning_qty = $request->traning_qty;
        $record->traning_price = $request->traning_price;
        $record->land_size_qty = $request->land_size_qty;
        $record->land_size_price = $request->land_size_price;
        $record->save();

        return response()->json(
            ['message' => 'Record created successfully',
                'data' => $record,
            ], 201, []);

=======
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
            $record = CropRevenueRecord::create([
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
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
    }

    public function create_production_record(Request $request)
    {
        //Validate the Data
        //Starting Transaction
        //Create new Date
        //create new record
        //End Transaction
        //return response

<<<<<<< HEAD
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop_name' => 'required',
            'country' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        $record = new CropProductionRecord();
        $record->user_id = $request->user_id;
        $record->crop_name = $request->crop_name;
        $record->country = $request->country;
        $record->ploughing_qty = $request->ploughing_qty;
        $record->ploughing_price = $request->ploughing_price;
        $record->seed_qty = $request->seed_qty;
        $record->seed_price = $request->seed_price;
        $record->fertilizer_qty = $request->fertilizer_qty;
        $record->fertilizer_price = $request->fertilizer_price;
        $record->herbicide_qty = $request->herbicide_qty;
        $record->herbicide_price = $request->herbicide_price;
        $record->pesticide_qty = $request->pesticide_qty;
        $record->pesticide_price = $request->pesticide_price;
        $record->labour_qty = $request->labour_qty;
        $record->labour_price = $request->labour_price;
        $record->packaging_qty = $request->packaging_qty;
        $record->packaging_price = $request->packaging_price;
        $record->storage_qty = $request->storage_qty;
        $record->storage_price = $request->storage_price;
        $record->transport_qty = $request->transport_qty;
        $record->transport_price = $request->transport_price;
        $record->variety_qty = $request->variety_qty;
        $record->variety_price = $request->variety_price;
        $record->equipment_qty = $request->equipment_qty;
        $record->equipment_price = $request->equipment_price;
        $record->land_size_qty = $request->land_size_qty;
        $record->land_size_price = $request->land_size_price;
        $record->save();
        return response()->json(
            ['message' => 'Record created successfully',
                'data' => $record,
            ], 201, []);

    }

    public function create_inventory_record(Request $request)
    {
        //Validate the Data
        //Starting Transaction
        //Create new Date
        //create new record
        //End Transaction
        //return response

        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop_name' => 'required',
            'country' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        $record = new CropInventory();
        $record->user_id = $request->user_id;
        $record->crop_name = $request->crop_name;
        $record->country = $request->country;
        $record->ploughing_qty = $request->ploughing_qty;
        $record->ploughing_price = $request->ploughing_price;
        $record->seed_qty = $request->seed_qty;
        $record->seed_price = $request->seed_price;
        $record->fertilizer_qty = $request->fertilizer_qty;
        $record->fertilizer_price = $request->fertilizer_price;
        $record->herbicides_qty = $request->herbicides_qty;
        $record->herbicides_price = $request->herbicides_price;
        $record->pesticide_qty = $request->pesticide_qty;
        $record->pesticide_price = $request->pesticide_price;
        $record->labour_qty = $request->labour_qty;
        $record->labour_price = $request->labour_price;
        $record->packaing_qty = $request->packaing_qty;
        $record->packaing_price = $request->packaing_price;
        $record->storage_qty = $request->storage_qty;
        $record->storage_price = $request->storage_price;
        $record->transport_qty = $request->transport_qty;
        $record->transport_price = $request->transport_price;
        $record->trees_qty = $request->trees_qty;
        $record->trees_price = $request->trees_price;
        $record->equipment_qty = $request->equipment_qty;
        $record->equipment_price = $request->equipment_price;
        $record->tools_qty = $request->tools_qty;
        $record->tools_price = $request->tools_price;
        $record->feeders_qty = $request->feeders_qty;
        $record->feeders_price = $request->feeders_price;
        $record->land_size_qty = $request->land_size_qty;
        $record->land_size_price = $request->land_size_price;
        $record->save();
        return response()->json(
            ['message' => 'Record created successfully',
                'data' => $record,
            ], 201, []);

    }
    public function get_crop_production_record()
    {
        $record = CropProductionRecord::all();
        return response()->json(['data' => $record], 200);
    }
    public function get_crop_revenue_record()
    {
        $response = CropRevenueRecord::all();
        return response()->json(['data' => $response], 200);
=======
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

            $record = CropProductionRecord::create([
                'user_id' => $request->user_id,
                'crop_name' => $request->crop_name,
                'country' => $request->country,
                'ploughing_qty' => $request->ploughing_qty,
                'ploughing_price' => $request->ploughing_price,
                'seed_qty' => $request->seed_qty,
                'seed_price' => $request->seed_price,
                'fertilizer_qty' => $request->fertilizer_qty,
                'fertilizer_price' => $request->fertilizer_price,
                'herbicides_qty' => $request->herbicides_qty,
                'herbicides_price' => $request->herbicides_price,
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
                'variety_qty' => $request->variety_qty,
                'variety_price' => $request->variety_price,
                'equipment_qty' => $request->equipment_qty,
                'equipment_price' => $request->equipment_price,
                'land_size_qty' => $request->land_size_qty,
                'land_size_price' => $request->land_size_price,
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
    }
}
