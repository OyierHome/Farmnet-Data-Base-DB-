<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Profile;
use App\Services\HandleImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function create_or_update(Request $request, HandleImageService $handleImage)
    {

        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'about' => 'required|string',
            'avatar' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'logo' => 'nullable|string',
            'location' => 'nullable|string',
            'crop' => 'nullable|array',
            'liveStock' => 'nullable|array',
            'data' => 'nullable|array',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }

        try {
            $profile = Profile::updateOrCreate(
                ['user_id' => $request->user_id],
                [
                    'user_id' => $request->user_id,
                    'about' => $request->about,
                    'logo' => $request->logo ?? $request->logo,
                    'avatar' => $request->avatar ?? $request->avatar,
                    'cover_image' => $request->cover_image ?? $request->cover_image,
                    'location' => $request->location ?? $request->location,
                    'crop' => array_merge($profile->crop ?? [], $request->crop ?? []),
                    'liveStock' => array_merge($profile->liveStock ?? [], $request->liveStock ?? []),
                    'data' => array_merge($profile->data ?? [], $request->data ?? []),
                ]
            );

            return response()->json(['success' => true, 'profile' => $profile], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing your request.', $e], 500);
        }


    }

    public function add_certificate(Request $request, HandleImageService $handleImage)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'certificate' => 'required|string',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }
        try {
            $storableData = [
                'user_id' => $request->user_id,
                'name' => $request->name,
                'certificate' => $request->certificate,
            ];
            $data = Certificate::create($storableData);

            return response()->json(['success' => true, 'certificate' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing your request.', $e], 500);
        }
    }
}



