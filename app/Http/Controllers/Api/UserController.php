<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\forget_password;
use App\Models\Organization;
use App\Models\User;
use App\Mail\User_register;
use App\Services\GenerateUniqueIdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store_user(Request $request , GenerateUniqueIdService $generateUniqueIdService)
    {
        // wrap all code in try-catch
        // Validate all inputs
        // Make Verification code
        // Create User
        // Throw error(if fails)
        // Create Organization
        // Throw error (if fails)
        // Send Verification Code by Mail
        // return response

        // Roll back of anything went wrong in catch section
        try {
            $organization = null;
            $commonRules = [
                'email' => 'required|email|unique:users',
                'country' => 'required',
                'phone' => 'required',
                'password' => 'required|min:6',
                'is_org' => 'required',
            ];

            if ($request->is_org === false || $request->is_org === "false") {
                $specificRules = [
                    'name' => 'required',
                    'sur_name' => 'required',
                    'stock_type' => 'required',
                ];
            } else {
                $specificRules = [
                    'org_name' => 'required',
                    'service_provider' => 'required',
                    'offtake_partner' => 'required',
                    'input_supplier' => 'required',
                    'development_partner' => 'required',
                    'education' => 'required',
                    'institude' => 'required',
                    'community' => 'required',
                    'invester' => 'required',
                ];
            }




            $validator = Validator::make($request->all(), array_merge($commonRules, $specificRules));
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 422);
            }

            DB::beginTransaction();


            // generate Unique ID
            $uniqueId =  $generateUniqueIdService->generateUserId($request->country, $request->service_provider ? $request->service_provider : 'Individual');


            $verificationCode = '';
            for ($i = 0; $i < 4; $i++) {
                $verificationCode .= mt_rand(1, 9);
            }

            $userData = [
                'unique_id' => $uniqueId,
                'email' => $request->email,
                'country' => $request->country,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'verify_code' => $verificationCode,
            ];

            if ($request->is_org === false || $request->is_org === "false") {
                $userData['name'] = $request->name;
                $userData['sur_name'] = $request->sur_name;
                $userData['stock_type'] = $request->stock_type;
            } else {
                $userData['org_name'] = $request->org_name;
            }

            $user = User::create($userData);

            if (!$user) {
                throw new \Exception('User not created');
            }
            if ($request->is_org === true || $request->is_org === "true") {
                $organization = Organization::create([
                    'user_id' => $user->id,
                    'service_provider' => $request->service_provider,
                    'offtake_partner' => $request->offtake_partner,
                    'input_supplier' => $request->input_supplier,
                    'development_partner' => $request->development_partner,
                    'education' => $request->education,
                    'institude' => $request->institude,
                    'community' => $request->community,
                    'invester' => $request->invester,
                ]);

                if (!$organization) {
                    throw new \Exception('Organization not created');
                }
            }


            $mailData = [
                'user_name' => $user->name,
                'verifictionCode' => $verificationCode,
            ];
            // Mail::to($user->email)->send(new User_register($mailData));

            DB::commit();
            return \response()->json(
                [
                    'success',
                    ['message' => 'User and organization created successfully'],
                    [
                        'user' => $user->with('organization')->with('profile')->first(),
                    ]
                ],
                200,
                []
            );

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => ['message' => $th->getMessage()]], 422, []);
        }
    }

    public function verifyUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        if ($user && $user->verify_code == $request->verificationCode) {
            $user->verify_code = null;
            $user->email_verified_at = now();
            $user->save();
            return response()->json(['success' => 'User verified successfully', 'user' => $user->with('organization')->with('profile')->first()], 200, []);
        } else {
            return response()->json(['error' => 'Verification Code is not correct'], 422);
        }
    }

    public function login(Request $request)
    {

        // Validate Credientails
        // Check if user exists
        // Check if password is correct
        // Create token
        // Return user

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user()->with('organization')->first();

            $token = $user->createToken('MyData')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user->with('organization')->with('profile')->first(),
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function resendVerificationCode(Request $request){
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $verificationCode = '';
        for ($i = 0; $i < 4; $i++) {
            $verificationCode .= mt_rand(1, 9);
        }
        $user->verify_code = $verificationCode;
        $user->save();

        $mailData = [
            'user_name' => $user->name,
            'verifictionCode' => $verificationCode,
        ];

        Mail::to($user->email)->send(new User_register($mailData));

        return response()->json(['success' => 'Verification Mail sended Successfully'], 200);
    }


    public function forgetPassword(Request $request)
    {
        // Validate email
        // Check if user exists
        // Generate new password
        // Send email
        // Return response

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $verificationCode = '';
        for ($i = 0; $i < 4; $i++) {
            $verificationCode .= mt_rand(1, 9);
        }
        $user->verify_code = $verificationCode;
        $user->save();

        $content = [
            'user_name' => $user->name,
            'verifictionCode' => $verificationCode,
        ];

        Mail::to($user->email)->send(new forget_password($content));

        return response()->json(['success' => 'Password reset Mail sended Successfully'], 200);
    }
    public function forgetPasswordVerify(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'verificationCode' => 'required',
            'password' => 'required|min:6',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        if ($user->verify_code == $request->verificationCode) {
            $user->password = Hash::make($request->password);
            $user->verify_code = null;
            $user->save();
            return response()->json(['success' => 'Password Updated Successfully', 'user' => $user], 200);
        } else {
            return response()->json(['error' => 'Verification Code is not correct'], 422);
        }
    }

    public function getUserByUniqueID(Request $request){
        $validate = Validator::make($request->all(), [
            'unique_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }
        $user = User::where('unique_id', $request->unique_id)->with('organization')->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json(['success' => 'User found', 'user' => $user], 200);
    }
}
