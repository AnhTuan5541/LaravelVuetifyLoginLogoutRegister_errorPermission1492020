<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class RegisterController extends Controller
{
    public function register( Request $request ) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|',
            'confirm_password' => 'required|string|same:password',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make( $request->input('password') ),
        ]);

        return response(['user' => $user, 'message' => 'Register Successfully'], 200);
    }
}
