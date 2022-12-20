<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function registerUser(UserRegistrationRequest $request){
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->save();
        $token = $user->createToken('MyToken')->accessToken;
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'data' => $user,
            'token' => $token
        ]);

    }
}
