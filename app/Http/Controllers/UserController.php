<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessEarthquakesJob;
use App\Mail\EarthquakeThresholdExceeded;
use App\Mail\TestMail;
use App\Models\User;
use App\UseCase\ProcessEarthquakeData\ProcessEarthquakeDataCommand;
use App\UseCase\ProcessEarthquakeData\Request\ProcessEarthquakeDataRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function __construct() {}

    public function create(Request $request)
    {
        // TODO error when no token
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

        return [
            'success' => true,
            'message' => 'User successfully created',
            'user' => $newUser
        ];
    }

    public function view(Request $request)
    {
        return User::all();
    }

    public function userDetails(Request $request)
    {
        return [
            'success' => true,
            'message' => 'Details successfully retrieved',
            'data' => $request->user()
        ];
    }
}
