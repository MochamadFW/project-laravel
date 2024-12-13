<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Exception;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|string|in:user,superadmin',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'User registered successfully'
            ]);
        } catch (QueryException $queryException) {
            // Handle database-related exceptions
            return response()->json([
                'status' => false,
                'message' => 'Database Error: ' . $queryException->getMessage()
            ])->setStatusCode(500);
        } catch (Exception $exception) {
            // Handle other general exceptions
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while registration: ' . $exception->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $checkUser = User::where('email', $request->email)->first();

            if (!$checkUser || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => true,
                    'message' => 'The provided credentials are incorrect!'
                ])->setStatusCode(403);
            }    
            $token = $checkUser->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'Login success!',
                'data' => [
                    'user' => $checkUser,
                    'token' => $token
                ]
            ])->setStatusCode(200);
        } catch (QueryException $queryException) {
            // Handle database-related exceptions
            return response()->json([
                'status' => false,
                'message' => 'Database Error: ' . $queryException->getMessage()
            ], 500);
        } catch (Exception $exception) {
            // Handle other general exceptions
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while logging in: ' . $exception->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->where('name', 'like', "auth_token")->delete();
            return response()->json([
                'status' => true,
                'message' => "Logged out successfully!"
            ]);
        } catch (Exception $exception) {
            // Handle other general exceptions
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while logging out: ' . $exception->getMessage()
            ], 500);
        }
    }
}
