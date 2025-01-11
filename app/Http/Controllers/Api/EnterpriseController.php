<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\EnterpriseStatement;
use App\Models\FoodCertificate;
use App\Models\Plan;
use App\Models\Task;
use App\Models\Testing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnterpriseController extends Controller
{
    public function create_testing(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            'stock_type' => 'required',
            'test_type' => 'required',
            'data' => 'required|array',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $data = new Testing($request->all());
        $data->save();

        return response()->json(['success' => true, 'data' => $data], 200);
    }
    public function create_bill(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            'bill_type' => 'required',
            'data' => 'required|array',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $data = new Bill($request->all());
        $data->save();

        return response()->json(['success' => true, 'data' => $data], 200);
    }
    public function create_statement(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            'data' => 'required|array',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $data = new EnterpriseStatement($request->all());
        $data->save();

        return response()->json(['success' => true, 'data' => $data], 200);
    }
    public function create_food_certificate(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            'data' => 'required|array',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $filename = uniqid() . '.' . $attachment->getClientOriginalExtension();
            $destination = public_path('Enterprise');
            $attachment->move($destination, $filename);
            $data = $request->input('data');
            // Ensure 'data' is an array and add the new key-value pair
            if (is_array($data)) {
                $data['attachment'] = $filename;
                // Merge the modified 'data' array back into the request
                $request->merge(['data' => $data]);
            }
        }


        $data = new FoodCertificate($request->all());
        $data->save();
        return response()->json(['success' => true, 'data' => $data], 200);
    }
    public function create_plan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            'data' => 'required|array',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $data = new Plan($request->all());
        $data->save();

        return response()->json(['success' => true, 'data' => $data], 200);
    }
    public function create_task(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            'data' => 'required|array',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $data = new Task($request->all());
        $data->save();

        return response()->json(['success' => true, 'data' => $data], 200);
    }
}
