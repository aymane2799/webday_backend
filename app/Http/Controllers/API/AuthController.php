<?php

namespace App\Http\Controllers\API;

use App\Actions\Auth\Login;
use App\Actions\Auth\Logout;
use App\Actions\Auth\Register;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function register(RegisterRequest $request)
    // {
    //     $register = new Register();

    //     return response()
    //         ->json($register($request), 201);
    // }

    public function register(Request $request){
$request->validate([
'name' => ['required', 'string', 'min:3', 'max:30'],
'email'=> ['required', 'email', 'unique:users,email'],
'password'=> ['required','min:8', 'confirmed'],
'password_confirmation' => ['required']
]);

$user = User::create([
    'name'=>$request->input('name'),
    'email'=>$request->input('email'),
    'password'=> Hash::make($request->input('password')),
]);

abort_if(!$user, 400,'Could not register !');

        $token = $user->createToken('#authToken')->plainTextToken;
        $token = explode('|', $token, 2)[1];

    }

    public function login(LoginRequest $request)
    {
        $login = new Login();

        return response()
            ->json($login($request), 200);
    }

    public function logout(Request $request)
    {
        $logout = new Logout();

        return response()->noContent($logout($request) ? 204 : 205);
    }
}
