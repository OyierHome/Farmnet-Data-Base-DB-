<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisiment;
use App\Models\User;
use App\Services\HandleImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvertisementController extends Controller
{
    public function index($id, Request $request)
    {
        if (!User::where('id', $id)->exists()) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user_id = $id;
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $advertisements = $user->advertisements()->get();
        return response()->json(['advertisements' => $advertisements], 200);
    }
    public function store_add(Request $request , HandleImageService $handleImageService)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop_type' => 'required|in:crop,livestock',
            'type' => 'required|in:product,service',
            'problem' => 'required',
            'diagnosis' => 'required',
            'management' => 'required',
            'product_name' => 'required',
            'product_image' => 'required|mimes:jpeg,png,jpg,img,web',
            'benefits' => 'required',
            'amount' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }

        $user = User::find($request->user_id);

        if (in_array($request->crop_type, ['crop', 'livestock'])) {
            $advertisementCount = $user->advertisements()
            ->where('crop_type', $request->crop_type)
            ->where('type', $request->type)
            ->count();

            $totalAdvertisementCount = $user->advertisements()
            ->where('crop_type', $request->crop_type)
            ->count();

            if ($advertisementCount >= 4) {
            return response()->json(['error' => 'Advertisement limit exceeded for ' . $request->type], 400);
            }

            if ($totalAdvertisementCount >= 8) {
            return response()->json(['error' => 'Total advertisement limit exceeded for ' . $request->crop_type], 400);
            }
        }


        if ($request->hasFile('product_image')) {
            $filename = $handleImageService->imageHandle($request->file('product_image'), 'advertisement');
        }


        $advertisement = $user->advertisements()->create([
            'user_id' => $user->id,
            'crop_type' => $request->crop_type,
            'type' => $request->type,
            'problem' => $request->problem,
            'diagnosis' => $request->diagnosis,
            'management' => $request->management,
            'product_name' => $request->product_name,
            'product_image' => $filename,
            'benefits' => $request->benefits,
            'amount' => $request->amount,
        ]);

        return response()->json(['advertisement' => $advertisement], 201);

    }
    public function edit_advertisement(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'crop_type' => 'required|in:crop,livestock',
            'type' => 'required|in:product,service',
            'problem' => 'required',
            'diagnosis' => 'required',
            'management' => 'required',
            'product_name' => 'required',
            'product_image' => 'nullable|mimes:jpeg,png,jpg,img,web',
            'benefits' => 'required',
            'amount' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }
        $user = User::find($request->user_id);

        $advertisement = $user->advertisements()->find($id);

        if (!$advertisement) {
            return response()->json(['error' => 'Advertisement not found'], 404);
        }

        if ($request->hasFile('product_image')) {
            if ($advertisement->product_image) {
                $oldImagePath = public_path('advertisement/' . $advertisement->product_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $image = $request->file('product_image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('advertisement'), $filename);
            $advertisement->product_image = $filename;
        }

        $advertisement->update([
            'crop_type' => $request->crop_type,
            'type' => $request->type,
            'problem' => $request->problem,
            'diagnosis' => $request->diagnosis,
            'management' => $request->management,
            'product_name' => $request->product_name,
            'product_image' => $advertisement->product_image,
            'benefits' => $request->benefits,
            'amount' => $request->amount,
        ]);

        return response()->json(['advertisement' => $advertisement], 200);
    }
    public function show($id)
    {
        $advertisement = Advertisiment::find($id);

        if (!$advertisement) {
            return response()->json(['error' => 'Advertisement not found'], 404);
        }


        return response()->json(['advertisement' => $advertisement], 200);
    }
}
