<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request)
    {
        //validation rules
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $valid->errors()
            ], 422);
        }
        $credentials = $request->only('email', 'password');
        if (JWTAuth::attempt($credentials)) {
            $user = JWTAuth::user();
            $token = JWTAuth::fromUser($user);
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'auth' => [
                    'token' => $token,
                    'type' => 'Bearer',
                    'expires_in' => 3600
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }

    public function Register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ];
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $valid->errors()
            ], 422);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully'
        ]);
    }
}
