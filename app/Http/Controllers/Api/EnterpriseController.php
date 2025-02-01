<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisiment;
use App\Models\Bill;
use App\Models\CropInventory;
use App\Models\CropProductionRecord;
use App\Models\CropRevenueRecord;
use App\Models\EnterpriseStatement;
use App\Models\FoodCertificate;
use App\Models\FundInsurance;
use App\Models\LivestockInventory;
use App\Models\LivestockProductionRecord;
use App\Models\LivestockRevenueRecord;
use App\Models\Plan;
use App\Models\Rate;
use App\Models\Reward;
use App\Models\Task;
use App\Models\Testing;
use App\Models\User;
use App\Services\HandleImageService;
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
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $request->merge(['country' => $user->country]);
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

    public function request_fund_insurance(Request $request)
    {
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

    public function Rate_review(Request $request, HandleImageService $imageService)
    {
        $validate = Validator::make($request->all(), [
            "user_id" => 'required|exists:users,id',
            "rater_id" => 'required|exists:users,id',
            'data' => 'required|array',
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:10240', // Max 10MB
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
            $videoFilename = $imageService->imageHandle($video, 'RateReview/videos');
            $data['video'] = $videoFilename;
        }

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $imageFilenames = [];
            foreach ($images as $image) {
                $imageFilename = $imageService->imageHandle($image, 'RateReview/images');
                $imageFilenames[] = $imageFilename;
            }
            $data['images'] = $imageFilenames;
        }

        $rateReview = new Rate($data);
        $rateReview->save();

        return response()->json(['success' => true, 'data' => $rateReview], 200);
    }

    public function add_rewards(Request $request)
    {
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

    public function crop_report_production(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop' => 'required',
            'country' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }


        $user_record = CropProductionRecord::where('user_id', $request->user_id)
            ->where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->latest()
            ->first();
        if (!$user_record) {
            return response()->json(['error' => 'No record found'], 404);
        }

        $oneMonthAgo = now()->subMonth();
        $recentRecords = CropProductionRecord::where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->where('created_at', '>=', $oneMonthAgo)
            ->get();

        $averageData = $recentRecords->reduce(function ($carry, $item) {
            foreach ($item->toArray() as $key => $value) {
                if (is_numeric($value)) {
                    $carry[$key] = ($carry[$key] ?? 0) + (float) $value;
                }
            }
            return $carry;
        }, []);

        $totalPrice = 0;
        foreach ($averageData as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $totalPrice += $value;
                unset($averageData[$key]);
            }
        }
        $averageData['total_price'] = $totalPrice;

        $userTotalPrice = 0;
        foreach ($user_record->toArray() as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $userTotalPrice += $value;
            }
        }
        $user_record->total_price = $userTotalPrice;




        foreach ($averageData as $key => $value) {
            $averageData[$key] = $value / $recentRecords->count();
        }
        $warnings = [];

        foreach ($averageData as $key => $averageValue) {
            if (isset($user_record->$key) && is_numeric($user_record->$key)) {
                $userValue = (float) $user_record->$key;
                $tenPercent = $averageValue * 0.1;

                if ($userValue < $averageValue - $tenPercent || $userValue > $averageValue + $tenPercent) {
                    $warnings[] = $key;
                }
            }
        }

        if (!empty($warnings)) {
            return response()->json([
                'warning' => $warnings,
                'average_data' => $averageData,
                'user_data' => $user_record,
                'price' => [
                    'total' => $totalPrice,
                    'user' => $userTotalPrice
                ]
            ], 200);
        }

        return response()->json([
            'success' => true,
            'average_data' => $averageData,
            "user_data" => $user_record,
            'price' => [
                'total' => $totalPrice,
                'user' => $userTotalPrice
            ]
        ], 200);

    }
    public function crop_report_revenue(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop' => 'required',
            'country' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }


        $user_record = CropRevenueRecord::where('user_id', $request->user_id)
            ->where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->latest()
            ->first();
        if (!$user_record) {
            return response()->json(['error' => 'No record found'], 404);
        }

        $oneMonthAgo = now()->subMonth();
        $recentRecords = CropRevenueRecord::where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->where('created_at', '>=', $oneMonthAgo)
            ->get();

        $averageData = $recentRecords->reduce(function ($carry, $item) {
            foreach ($item->toArray() as $key => $value) {
                if (is_numeric($value)) {
                    $carry[$key] = ($carry[$key] ?? 0) + (float) $value;
                }
            }
            return $carry;
        }, []);

        $totalPrice = 0;
        foreach ($averageData as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $totalPrice += $value;
                unset($averageData[$key]);
            }
        }
        $averageData['total_price'] = $totalPrice;

        $userTotalPrice = 0;
        foreach ($user_record->toArray() as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $userTotalPrice += $value;
            }
        }
        $user_record->total_price = $userTotalPrice;




        foreach ($averageData as $key => $value) {
            $averageData[$key] = $value / $recentRecords->count();
        }
        $warnings = [];

        foreach ($averageData as $key => $averageValue) {
            if (isset($user_record->$key) && is_numeric($user_record->$key)) {
                $userValue = (float) $user_record->$key;
                $tenPercent = $averageValue * 0.1;

                if ($userValue < $averageValue - $tenPercent || $userValue > $averageValue + $tenPercent) {
                    $warnings[] = $key;
                }
            }
        }

        if (!empty($warnings)) {
            return response()->json([
                'warning' => $warnings,
                'average_data' => $averageData,
                'user_data' => $user_record,
                'price' => [
                    'total' => $totalPrice,
                    'user' => $userTotalPrice
                ]
            ], 200);
        }

        return response()->json([
            'success' => true,
            'average_data' => $averageData,
            "user_data" => $user_record,
            'price' => [
                'total' => $totalPrice,
                'user' => $userTotalPrice
            ]
        ], 200);

    }
    public function crop_report_inventory(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop' => 'required',
            'country' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }


        $user_record = CropInventory::where('user_id', $request->user_id)
            ->where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->latest()
            ->first();
        if (!$user_record) {
            return response()->json(['error' => 'No record found'], 404);
        }

        $oneMonthAgo = now()->subMonth();
        $recentRecords = CropInventory::where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->where('created_at', '>=', $oneMonthAgo)
            ->get();

        $averageData = $recentRecords->reduce(function ($carry, $item) {
            foreach ($item->toArray() as $key => $value) {
                if (is_numeric($value)) {
                    $carry[$key] = ($carry[$key] ?? 0) + (float) $value;
                }
            }
            return $carry;
        }, []);

        $totalPrice = 0;
        foreach ($averageData as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $totalPrice += $value;
                unset($averageData[$key]);
            }
        }
        $averageData['total_price'] = $totalPrice;

        $userTotalPrice = 0;
        foreach ($user_record->toArray() as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $userTotalPrice += $value;
            }
        }
        $user_record->total_price = $userTotalPrice;




        foreach ($averageData as $key => $value) {
            $averageData[$key] = $value / $recentRecords->count();
        }
        $warnings = [];

        foreach ($averageData as $key => $averageValue) {
            if (isset($user_record->$key) && is_numeric($user_record->$key)) {
                $userValue = (float) $user_record->$key;
                $tenPercent = $averageValue * 0.1;

                if ($userValue < $averageValue - $tenPercent || $userValue > $averageValue + $tenPercent) {
                    $warnings[] = $key;
                }
            }
        }

        if (!empty($warnings)) {
            return response()->json([
                'warning' => $warnings,
                'average_data' => $averageData,
                'user_data' => $user_record,
                'price' => [
                    'total' => $totalPrice,
                    'user' => $userTotalPrice
                ]
            ], 200);
        }

        return response()->json([
            'success' => true,
            'average_data' => $averageData,
            "user_data" => $user_record,
            'price' => [
                'total' => $totalPrice,
                'user' => $userTotalPrice
            ]
        ], 200);

    }
    public function livestock_report_production(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop' => 'required',
            'country' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }


        $user_record = LivestockProductionRecord::where('user_id', $request->user_id)
            ->where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->latest()
            ->first();
        if (!$user_record) {
            return response()->json(['error' => 'No record found'], 404);
        }

        $oneMonthAgo = now()->subMonth();
        $recentRecords = LivestockProductionRecord::where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->where('created_at', '>=', $oneMonthAgo)
            ->get();

        $averageData = $recentRecords->reduce(function ($carry, $item) {
            foreach ($item->toArray() as $key => $value) {
                if (is_numeric($value)) {
                    $carry[$key] = ($carry[$key] ?? 0) + (float) $value;
                }
            }
            return $carry;
        }, []);

        $totalPrice = 0;
        foreach ($averageData as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $totalPrice += $value;
                unset($averageData[$key]);
            }
        }
        $averageData['total_price'] = $totalPrice;

        $userTotalPrice = 0;
        foreach ($user_record->toArray() as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $userTotalPrice += $value;
            }
        }
        $user_record->total_price = $userTotalPrice;




        foreach ($averageData as $key => $value) {
            $averageData[$key] = $value / $recentRecords->count();
        }
        $warnings = [];

        foreach ($averageData as $key => $averageValue) {
            if (isset($user_record->$key) && is_numeric($user_record->$key)) {
                $userValue = (float) $user_record->$key;
                $tenPercent = $averageValue * 0.1;

                if ($userValue < $averageValue - $tenPercent || $userValue > $averageValue + $tenPercent) {
                    $warnings[] = $key;
                }
            }
        }

        if (!empty($warnings)) {
            return response()->json([
                'warning' => $warnings,
                'average_data' => $averageData,
                'user_data' => $user_record,
                'price' => [
                    'total' => $totalPrice,
                    'user' => $userTotalPrice
                ]
            ], 200);
        }

        return response()->json([
            'success' => true,
            'average_data' => $averageData,
            "user_data" => $user_record,
            'price' => [
                'total' => $totalPrice,
                'user' => $userTotalPrice
            ]
        ], 200);

    }
    public function livestock_report_revenue(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop' => 'required',
            'country' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }


        $user_record = LivestockRevenueRecord::where('user_id', $request->user_id)
            ->where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->latest()
            ->first();
        if (!$user_record) {
            return response()->json(['error' => 'No record found'], 404);
        }

        $oneMonthAgo = now()->subMonth();
        $recentRecords = LivestockRevenueRecord::where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->where('created_at', '>=', $oneMonthAgo)
            ->get();

        $averageData = $recentRecords->reduce(function ($carry, $item) {
            foreach ($item->toArray() as $key => $value) {
                if (is_numeric($value)) {
                    $carry[$key] = ($carry[$key] ?? 0) + (float) $value;
                }
            }
            return $carry;
        }, []);

        $totalPrice = 0;
        foreach ($averageData as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $totalPrice += $value;
                unset($averageData[$key]);
            }
        }
        $averageData['total_price'] = $totalPrice;

        $userTotalPrice = 0;
        foreach ($user_record->toArray() as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $userTotalPrice += $value;
            }
        }
        $user_record->total_price = $userTotalPrice;




        foreach ($averageData as $key => $value) {
            $averageData[$key] = $value / $recentRecords->count();
        }
        $warnings = [];

        foreach ($averageData as $key => $averageValue) {
            if (isset($user_record->$key) && is_numeric($user_record->$key)) {
                $userValue = (float) $user_record->$key;
                $tenPercent = $averageValue * 0.1;

                if ($userValue < $averageValue - $tenPercent || $userValue > $averageValue + $tenPercent) {
                    $warnings[] = $key;
                }
            }
        }

        if (!empty($warnings)) {
            return response()->json([
                'warning' => $warnings,
                'average_data' => $averageData,
                'user_data' => $user_record,
                'price' => [
                    'total' => $totalPrice,
                    'user' => $userTotalPrice
                ]
            ], 200);
        }

        return response()->json([
            'success' => true,
            'average_data' => $averageData,
            "user_data" => $user_record,
            'price' => [
                'total' => $totalPrice,
                'user' => $userTotalPrice
            ]
        ], 200);

    }
    public function livestock_report_inventory(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop' => 'required',
            'country' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }


        $user_record = LivestockInventory::where('user_id', $request->user_id)
            ->where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->latest()
            ->first();
        if (!$user_record) {
            return response()->json(['error' => 'No record found'], 404);
        }

        $oneMonthAgo = now()->subMonth();
        $recentRecords = LivestockInventory::where('crop_name', $request->crop)
            ->where('country', $request->country)
            ->where('created_at', '>=', $oneMonthAgo)
            ->get();

        $averageData = $recentRecords->reduce(function ($carry, $item) {
            foreach ($item->toArray() as $key => $value) {
                if (is_numeric($value)) {
                    $carry[$key] = ($carry[$key] ?? 0) + (float) $value;
                }
            }
            return $carry;
        }, []);

        $totalPrice = 0;
        foreach ($averageData as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $totalPrice += $value;
                unset($averageData[$key]);
            }
        }
        $averageData['total_price'] = $totalPrice;

        $userTotalPrice = 0;
        foreach ($user_record->toArray() as $key => $value) {
            if (str_ends_with($key, '_price')) {
                $userTotalPrice += $value;
            }
        }
        $user_record->total_price = $userTotalPrice;




        foreach ($averageData as $key => $value) {
            $averageData[$key] = $value / $recentRecords->count();
        }
        $warnings = [];

        foreach ($averageData as $key => $averageValue) {
            if (isset($user_record->$key) && is_numeric($user_record->$key)) {
                $userValue = (float) $user_record->$key;
                $tenPercent = $averageValue * 0.1;

                if ($userValue < $averageValue - $tenPercent || $userValue > $averageValue + $tenPercent) {
                    $warnings[] = $key;
                }
            }
        }

        if (!empty($warnings)) {
            return response()->json([
                'warning' => $warnings,
                'average_data' => $averageData,
                'user_data' => $user_record,
                'price' => [
                    'total' => $totalPrice,
                    'user' => $userTotalPrice
                ]
            ], 200);
        }

        return response()->json([
            'success' => true,
            'average_data' => $averageData,
            "user_data" => $user_record,
            'price' => [
                'total' => $totalPrice,
                'user' => $userTotalPrice
            ]
        ], 200);

    }
    public function getInventory(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop_name' => 'required',
            'crop_type' => 'required|in:crop,livestock'
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $record = null;
        if ($request->crop_type == 'livestock') {
            $record = LivestockInventory::where('user_id', $request->user_id)
                ->where('crop_name', $request->crop_name)
                ->latest()
                ->first();
        } else if ($request->crop_type == 'crop') {
            $record = CropInventory::where('user_id', $request->user_id)
                ->where('crop_name', $request->crop_name)
                ->where('crop_type', $request->crop_type)
                ->latest()
                ->first();
        }

        return response()->json(['success' => true, 'data' => $record], 200);
    }

    public function monetInOut(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $moneyIn = Bill::where('user_id', $request->user_id)
            ->where('bill_type', 'invoice')
            ->get();
        $moneyOut = Bill::where('data->customer_info->customer_id', $user->unique_id)
            ->where('bill_type', 'invoice')
            ->get();

        return response()->json([
            'success' => true,
            'money_in' => $moneyIn,
            'money_out' => $moneyOut
        ], 200);
    }

    public function getBillById(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'bill_id' => 'required|exists:bills,id'
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $bill = Bill::find($request->bill_id);
        if (!$bill) {
            return response()->json(['error' => 'Bill not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $bill], 200);
    }

    public function getSimulator(Request $request)
    {
        $validate = Validator::make(request()->all(), [
            'country' => 'required',
            'crop_name' => 'required',
            'crop_type' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $data = null;
        if ($request->crop_type == 'livestock') {
            $data = LivestockProductionRecord::where('crop_name', $request->crop_name)
                ->where('country', $request->country)
                ->get();
        }
        if ($request->crop_type == 'crop') {
            $data = CropProductionRecord::where('crop_name', $request->crop_name)
                ->where('country', $request->country)
                ->get();
        }

        if ($data) {
            $averages = [];
            foreach ($data as $record) {
                foreach ($record->toArray() as $key => $value) {
                    if (is_numeric($value)) {
                        $averages[$key] = ($averages[$key] ?? 0) + $value;
                    }
                }
            }
            foreach ($averages as $key => &$value) {
                $value /= $data->count();
            }
        }
        return response()->json(['success' => true, 'average_data' => $averages], 200);

    }

    public function getCatalogData(Request $request){
        $validate = Validator::make(request()->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 404);
        }
        $data = Advertisiment::where('user_id', $request->user_id)->get();
        if (!$data) {
            return response()->json(['error' => 'No data found'], 404);
        }
        return response()->json(['success' => true, 'data' => $data], 200);

    }
}
