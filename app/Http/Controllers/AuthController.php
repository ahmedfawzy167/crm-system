<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|alpha|between:5,50',
            'email' => 'required|string|email|unique:users|max:100',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            'status' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => "Success",
            'message' => 'Registeration is Done',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['email' => 'This Email Doesn\'t Match Our Records!'], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['password' => 'Wrong Password!'], 401);
        }

        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $token = $user->createToken('crm token')->plainTextToken;
            $user->token = $token;
            return response()->json([
                'status' => "Success",
                'message' => 'Login Successfully',
                'user' => $user,
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'message' => 'Token Not Found'
            ], 401);
        }

        if ($request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => "Success",
                'message' => 'Logged Out Successfully',
            ], 200);
        }
    }

    public function profile(Request $request)
    {
        return $request->user();
    }
}
