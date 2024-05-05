<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            //find the user by email
            $user = User::where('email', $credentials['email'])->first();
    
            //to check if the user exists
            if ($user) {
                //password check
                if ($credentials['password'] === $user->password) {
                    //login successful
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()->json(['token' => $token], 200);
                }
            }
    
            //if login failed
            throw ValidationException::withMessages(['email' => 'Invalid credentials']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
