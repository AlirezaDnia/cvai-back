<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function __invoke(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
            'plan_type' => 'free'
        ]);

        $token = $user->createToken('cvai_auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
