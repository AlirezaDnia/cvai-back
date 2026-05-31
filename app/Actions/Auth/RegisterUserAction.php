<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function execute(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer', // به صورت پیش‌فرض همه کستمر هستند
            'plan_type' => 'free'
        ]);

        // ایجاد توکن Sanctum برای کاربر
        $token = $user->createToken('cvai_auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
