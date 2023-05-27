<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Register
{
    public function __invoke(RegisterRequest $request)
    {
        $data = DB::transaction(function () use ($request) {
            $password = Hash::make($request->input('password'));

            $user = User::create([
                'name'  =>  $request->input('name'),
                'email' =>  $request->input('email'),
                'password' =>  $password,
            ]);

            // $user->sendEmailVerificationNotification();

            abort_if(!$user, 400, 'Could not Register !');

            event(new Registered($user));

            $token = $user->createToken('#authToken')->plainTextToken;
            $token = explode('|', $token, 2)[1];

            return [
                'user'  =>  $user,
                'token' =>  $token,
            ];
        });

        return $data;
    }
}
