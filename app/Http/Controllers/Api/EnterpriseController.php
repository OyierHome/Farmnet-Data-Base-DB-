<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\EnterpriseStatement;
use App\Models\FoodCertificate;
use App\Models\FundInsurance;
use App\Models\Plan;
use App\Models\Rate;
use App\Models\Reward;
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

    public function request_fund_insurance(Request $request){
        $validate = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            'data' => 'required|array',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $data = new FundInsurance($request->all());
        $data->save();

    }

    public function Rate_review(Request $request){
        $validate = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            "rater_id" => 'required|exists:users,id',
            'data' => 'required|array',
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:20480', // Max 20MB
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB per image
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        if ($request->user_id == $request->rater_id) {
            return response()->json(['error' => 'You cannot rate yourself'], 404);
        }
        $data = $request->all();

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoFilename = uniqid() . '.' . $video->getClientOriginalExtension();
            $videoDestination = public_path('RateReview/videos');
            $video->move($videoDestination, $videoFilename);
            $data['video'] = $videoFilename;
        }

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $imageFilenames = [];
            foreach ($images as $image) {
            $imageFilename = uniqid() . '.' . $image->getClientOriginalExtension();
            $imageDestination = public_path('RateReview/images');
            $image->move($imageDestination, $imageFilename);
            $imageFilenames[] = $imageFilename;
            }
            $data['images'] = $imageFilenames;
        }

        $rateReview = new Rate($data);
        $rateReview->save();

        return response()->json(['success' => true, 'data' => $rateReview], 200);
    }

    public function add_rewards(Request $request){
        $validate = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            'points' => 'required|integer',
            'data' => 'required|array',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $existingData = Reward::where('user_id', $request->user_id)->first();

        $newData = $request->input('data');
        $existingDataArray = $existingData->data ?? [];

        foreach ($newData as $key => $value) {
            if (array_key_exists($key, $existingDataArray)) {
            return response()->json(['error' => "The field '{$key}' already exists in the previous data"], 404);
            }
        }

        $mergedData = array_merge($existingDataArray, $newData);
        $mergedData['points'] = ($existingData->points ?? 0) + $request->points;

        $data = Reward::updateOrCreate(
            ['user_id' => $request->user_id],
            ['data' => $mergedData, 'points' => $mergedData['points']]
        );
        return response()->json(['success' => true, 'data' => $data], 200);
    }
}
