<?php

namespace App\Actions\Auth;

use Illuminate\Http\Request;

class Logout
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $currentToken = $user->currentAccessToken();

        return $currentToken->delete();
    }
}
