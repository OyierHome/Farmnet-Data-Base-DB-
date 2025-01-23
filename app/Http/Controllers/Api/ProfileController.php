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
            'avatar' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'nullable|string',
            'crop' => 'nullable|array',
            'liveStock' => 'nullable|array',
            'data' => 'nullable|array',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }

        $avatar = $cover_image = $logo = null;

        try {
            if ($request->hasFile('avatar')) {
                $avatar = $handleImage->imageHandle($request->file('avatar'), 'Profile/Avatar');
                $request->avatar = $avatar;
            }
            if ($request->hasFile('cover_image')) {
                $cover_image = $handleImage->imageHandle($request->file('cover_image'), 'Profile/CoverImage');
                $request->cover_image = $cover_image;
            }
            if ($request->hasFile('logo')) {
                $logo = $handleImage->imageHandle($request->file('logo'), 'Profile/Logo');
                $request->logo = $logo;
            }


            $storableData = [
                'user_id' => $request->user_id,
                'about' => $request->about,
                'logo' => $logo,
                'avatar' => $avatar,
                'cover_image' => $cover_image,
                'location' => $request->location,
                'crop' => $request->crop,
                'liveStock' => $request->liveStock,
                'data' => $request->data,
            ];
            $oldData = Profile::where('user_id', $request->user_id)->first();
            $profile = Profile::updateOrCreate(
                ['user_id' => $request->user_id],
                $storableData
            );

            if ($oldData) {
                if ($avatar && $oldData->avatar) {
                    $handleImage->deleteImage($oldData->avatar);
                }
                if ($cover_image && $oldData->cover_image) {
                    $handleImage->deleteImage($oldData->cover_image);
                }
                if ($logo && $oldData->logo) {
                    $handleImage->deleteImage($oldData->logo);
                }
            }




            return response()->json(['success' => true, 'profile' => $profile], 200);

        } catch (\Exception $e) {
            // Rollback and delete images if any error occurs
            if ($avatar) {
                $handleImage->deleteImage($avatar);
            }
            if ($cover_image) {
                $handleImage->deleteImage($cover_image);
            }
            if ($logo) {
                $handleImage->deleteImage($logo);
            }

            return response()->json(['error' => 'An error occurred while processing your request.', $e], 500);
        }


    }

    public function add_certificate(Request $request, HandleImageService $handleImage)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'certificate' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }
        $certificate = null;
        try {
            if ($request->hasFile('certificate')) {
                $certificate = $handleImage->imageHandle($request->file('certificate'), 'Profile/Certificate');
                $request->certificate = $certificate;

                $storableData = [
                    'user_id' => $request->user_id,
                    'name' => $request->name,
                    'certificate' => $certificate,
                ];
                $data = Certificate::create($storableData);

                return response()->json(['success' => true, 'certificate' => $data], 200);
            }
        } catch (\Exception $e) {
            if ($certificate) {
                $handleImage->deleteImage($certificate);
            }

            return response()->json(['error' => 'An error occurred while processing your request.', $e], 500);
        }
    }
}



