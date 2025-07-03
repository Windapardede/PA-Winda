<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;



class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = auth::user();

        if ($user->role === 'admin' || $user->role === 'mentor' || $user->role === 'hrd') {
            return redirect('/home');
        }

        return redirect('/posisi');
    }
}
