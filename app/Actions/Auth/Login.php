<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Login
{
    public function __invoke(LoginRequest $request)
    {
        $credetials = [
            'email' =>  $request->input('email'),
            'password' =>  $request->input('password'),
        ];

        if (Auth::attempt($credetials)) {
            $user = Auth::user();
            $token = $user->createToken('#authToken')->plainTextToken;
            $token = explode('|', $token, 2)[1];


            return [
                'user'  =>  $user,
                'token' =>  $token
            ];
        } else {
            abort(401, 'Verify your credentials !');
        }
    }
}
