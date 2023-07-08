<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTokenRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TokenController extends Controller
{
    public function store(StoreTokenRequest $request): Response
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response($user->createToken($request->device_name)->plainTextToken, 200);
    }
}
