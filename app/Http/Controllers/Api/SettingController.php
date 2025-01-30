<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminRight;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function upDateUsers(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'organization' => 'nullable|array',
        ]);
        if ($validate->fails()){
            return response()->json(['error' => $validate->errors()], 404);
        }

        $user = User::find($request->user_id);
        if ($user && isset($request['organization'])) {
            $organizationData = $request['organization'];
            if ($user->organization) {
                $user->organization()->update($organizationData);
            }else{
                return response()->json(['message' => 'This user is not an organization'], 404);
            }
        }

        if ($user) {
            $user->update($request->all());
            $user->load('organization');
            return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function create_updateSetting(Request $request){
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'data' => 'required|array',
        ]);
        if ($validate->fails()){
            return response()->json(['error' => $validate->errors()], 404);
        }

        $userSetting = Setting::where('user_id', $request->user_id)->first();

        if ($userSetting) {
            $userSetting->update(['data' => $request->data]);
            return response()->json(['message' => 'Setting updated successfully', 'setting' => $userSetting], 200);
        } else {
            $newSetting = Setting::create([
                'user_id' => $request->user_id,
                'data' => $request->data,
            ]);
            return response()->json(['message' => 'Setting created successfully', 'setting' => $newSetting], 201);
        }

    }

    public function adminRight(Request $request){
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'right' => 'required|array',
        ]);
        if ($validate->fails()){
            return response()->json(['error' => $validate->errors()], 404);
        }

        $AdminRight =AdminRight::updateOrCreate(
            ['user_id' => $request->user_id],
            ['right' => $request->right]);

        return response()->json(['message' => 'Right updated successfully', 'right' => $AdminRight], 200);
    }

    public function getUserRight(Request $request){
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validate->fails()){
            return response()->json(['error' => $validate->errors()], 404);
        }

        $AdminRight =AdminRight::where('user_id', $request->user_id)->first();

        if (!$AdminRight) {
            return response()->json(['message' => 'No right found'], 404);
        }
        return response()->json(['message' => 'Right found successfully', 'right' => $AdminRight], 200);
    }
}
