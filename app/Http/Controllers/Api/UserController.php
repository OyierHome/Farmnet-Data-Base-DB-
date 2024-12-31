<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
<<<<<<< HEAD
use App\Mail\User_register;
=======
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
<<<<<<< HEAD
use Illuminate\Support\Facades\Mail;
=======
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store_user(Request $request)
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

<<<<<<< HEAD
         $validator = Validator::make($request->all(), [
=======
            $validator = Validator::make($request->all(), [
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
                'name' => 'required',
                'sur_name' => 'required',
                'email' => 'required|email|unique:users',
                'country' => 'required',
                'phone' => 'required',
                'password' => 'required|min:6',
                'stock_type' => 'required',
<<<<<<< HEAD
=======
                'org_name' => 'required',
                'org_country' => 'required',
                'org_phone' => 'required',
                'org_email' => 'required|email|unique:organizations',
                'org_password' => 'required|min:6',
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
                'service_provider' => 'required',
                'offtake_partner' => 'required',
                'input_supplier' => 'required',
                'development_partner' => 'required',
                'education' => 'required',
                'institude' => 'required',
                'community' => 'required',
                'invester' => 'required',
<<<<<<< HEAD
                'is_org' => 'required',
            ]);

            if ($request->is_org === true || $request->is_org === "true") {
                $validator = Validator::make($request->all(), [
                    'org_name' => 'required',
                    'org_country' => 'required',
                    'org_phone' => 'required',
                    'org_email' => 'required|email|unique:organizations',
                    'org_password' => 'required|min:6',
                ]);
            }
=======
            ]);

>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 422);
            }

            DB::beginTransaction();

            $verificationCode = '';
            for ($i = 0; $i < 4; $i++) {
                $verificationCode .= mt_rand(1, 9);
            }

            $user = User::create([
                'name' => $request->name,
                'sur_name' => $request->sur_name,
                'email' => $request->email,
                'country' => $request->country,
                'phone' => $request->phone,
                'stock_type' => $request->stock_type,
                'password' => Hash::make($request->password),
                'verify_code' => $verificationCode,
            ]);

            if (!$user) {
                throw new \Exception('User not created');
            }

            $organization = Organization::create([
                'user_id' => $user->id,
<<<<<<< HEAD
=======
                'org_name' => $request->org_name,
                'org_country' => $request->org_country,
                'org_phone' => $request->org_phone,
                'org_email' => $request->org_email,
                'org_password' => Hash::make($request->org_password),
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
                'service_provider' => $request->service_provider,
                'offtake_partner' => $request->offtake_partner,
                'input_supplier' => $request->input_supplier,
                'development_partner' => $request->development_partner,
                'education' => $request->education,
                'institude' => $request->institude,
                'community' => $request->community,
                'invester' => $request->invester,
            ]);
<<<<<<< HEAD
            if ($request->is_org === true || $request->is_org === "true") {
                $organization->update([
                    'org_name' => $request->org_name,
                    'org_country' => $request->org_country,
                    'org_phone' => $request->org_phone,
                    'org_email' => $request->org_email,
                    'org_password' => Hash::make($request->org_password),
                ]);
            }
=======
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b

            if (!$organization) {
                throw new \Exception('Organization not created');
            }

            $mailData = [
                'user_name' => $user->name,
                'verifictionCode' => $verificationCode,
            ];
<<<<<<< HEAD
             Mail::to($user->email)->send(new User_register($mailData));
=======
            // Mail::to($user->email)->send(new User_register($mailData));
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b

            DB::commit();
            return \response()->json(['success', ['message' => 'User and organization created successfully'],
                [
                    'user' => $user,
                    'organization' => $organization,
                ]],
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
        if ($user->verify_code == $request->verificationCode) {
            $user->verify_code = null;
            $user->email_verified_at = now();
            $user->save();
            return response()->json(['success' => 'User verified successfully', 'user' => ' ' . $user->with('organization')->first()], 200, []);
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
                'user' => $user,
            ]);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }

    }
}
