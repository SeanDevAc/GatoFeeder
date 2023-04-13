<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponses;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request) {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('', 'credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->succes([
            'user' => $user,
            'token' => $user->createToken('api token of ' . $user->name)->plainTextToken
        ]);
    }

    public function register(StoreUserRequest $request) {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->succes([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ]);
        
    }

    public function logout() {
        Auth::user()->currentAccessToken()->delete();

        return $this->succes([
            'message' => 'ur logged out now'
        ]);
    }
}
