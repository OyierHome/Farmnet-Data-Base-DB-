<?php

namespace App\Http\Controllers\Api\Enterprise;

use App\Http\Controllers\Controller;
use App\Models\EnterpriseLivestockProduction;
use App\Models\EnterpriseLivestockRevenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LivestockController extends Controller
{
    public function create_production(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop_name' => 'required',
            'country' => 'required',
        ]);
        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ]);
        }
        $data = $request->all();

        $record = EnterpriseLivestockProduction::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Livestock production record created successfully',
            'data' => $record
        ]);

    }
    public function create_revenue(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop_name' => 'required',
            'country' => 'required',
        ]);
        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ]);
        }
        $data = $request->all();
        $record = EnterpriseLivestockRevenue::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Livestock revenue record created successfully',
            'data' => $record
        ]);
    }
}
