<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(){
        if(Auth::attempt(['email' => request()->get('email'),'password' => request()->get('password')])){
            $user = Auth::user();
            $token = auth()->user()->createToken('API TOKEN')->accessToken;
            return response()->json([
                'status' => true,
                'message' => 'Logged in successfully',
                'data' => $user,
                'token' => $token
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized user'
            ]);
        }
    }

    public function getUserDetails(){
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'message' => 'User details updated successfully',
            'data' => $user
        ]);
    }
}
