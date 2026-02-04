<?php

namespace App\Http\Controllers;

use App\Helper\CacheKeyHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct() {}

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $newUser = User::factory()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ADMIN_ROLE
        ]);

        Cache::delete(CacheKeyHelper::getAllUsersCacheKey());

        return [
            'success' => true,
            'message' => 'User successfully created',
            'user' => $newUser
        ];
    }

    public function view()
    {
        if (Cache::has(CacheKeyHelper::getAllUsersCacheKey())) {
            return Cache::get(CacheKeyHelper::getAllUsersCacheKey());
        }

        $allUsers = User::all();

        Cache::forever(CacheKeyHelper::getAllUsersCacheKey(), $allUsers);

        return ['users' => $allUsers];
    }

    public function userDetails(Request $request)
    {
        if (Cache::has(CacheKeyHelper::getUserCacheKey($request->user()))) {
            return Cache::get(CacheKeyHelper::getUserCacheKey($request->user()));
        }

        return [
            'success' => true,
            'message' => 'Details successfully retrieved',
            'data' => $request->user()
        ];
    }
}
