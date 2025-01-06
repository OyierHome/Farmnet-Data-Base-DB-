<?php

namespace App\Http\Controllers\Api\Enterprise;

use App\Http\Controllers\Controller;
use App\Models\EnterpriseCropProduction;
use App\Models\EnterpriseCropRevenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CropController extends Controller
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

        $record = EnterpriseCropProduction::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Crop production record created successfully',
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
        $record = EnterpriseCropRevenue::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Crop revenue record created successfully',
            'data' => $record
        ]);
    }
}
