<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory as Faker;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function firstLogin(Request $request)
    {
        $faker = Faker::create();

        $user = new User();
        $user->name = $faker->name;
        $user->email = $faker->unique()->safeEmail;
        $user->password = bcrypt('password');
        $user->save();

        $token = $user->createToken('authToken')->plainTextToken;

        Cookie::queue('auth_token', $token, 60);

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}
