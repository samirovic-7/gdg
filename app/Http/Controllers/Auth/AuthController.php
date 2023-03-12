<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Facades\CauserResolver;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'firstname' => 'required|max:20',
                'lastname' => 'required|max:20',
                'phonenumber' => 'required|numeric|unique:users',
                'role' => 'required|exists:roles,name',
                'email' => 'email|unique:users',
                'password' => 'required|min:6',
                'role'=>'required',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }
            
            
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
                'role' => $request->role,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role'=>$request->role
            ]);
            
            $userRole = Role::where('name',$request->role)->with('permissions')->first();
            $userRole =  $user->syncPermissions($userRole->permissions);
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
            ], 200);

        } catch (\Throwable$th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }

    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'email|required_without:phonenumber',
                    'phonenumber' => 'numeric|required_without:email',
                    'password' => 'required',
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }

            if (is_numeric($request->phonenumber)) {
                if (!Auth::attempt($request->only(['phonenumber', 'password']))) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Phone number & Password does not match with our record.',
                    ], 401);
                }
                $user = User::where('phonenumber', $request->phonenumber)->first();
            } else {
                if (!Auth::attempt($request->only(['email', 'password']))) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Email & Password does not match with our record.',
                    ], 401);
                }
                $user = User::where('email', $request->email)->first();
            }
            auth()->login($user);
            activity()
                ->causedBy($user)
                ->withProperties(['attributes' => $user])
                ->log('User Successfully Logged In');
            $userPermissions = Permission::whereHas('users',function($q) use($user){
                $q->where('model_id',$user->id);
            })->get();
          
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'userAbilities' => $userPermissions,
            ], 200);

        } catch (\Throwable$th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $accessToken = $user->currentAccessToken();
        $accessToken->delete();
        return response()->json([
            'message' => 'User Logged out Successfully',

        ]);
    }

    public function user()
    {   
        return response()->json(User::all());
    }   


}
