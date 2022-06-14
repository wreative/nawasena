<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectTo = '/home';

    public function login(Request $request)
    {
        $request = Request::create('/oauth/token', 'POST', [
            'username' => $request->email,
            'password' => $request->password,

            'client_id'        => config('veyaz.site_client_id'),
            'client_secret'    => config('veyaz.site_client_secret'),
            'grant_type'    => 'password'
        ]);

        $request->headers->set('accept', 'application/json');
        $request->headers->set('Content-Type', 'application/json');

        $response = app()->handle($request);

        $result = json_decode($response->getContent(), true);

        return $result;
    }

    public function register(Request $request)
    {
        // $request->validate([
        //     'fName' => 'required|string',
        //     'lName' => 'required|string',
        //     'email' => 'required|string|email|unique:users',
        //     'password' => 'required|string'
        // ]);
        // $user = new User;
        // $user->first_name = $request->fName;
        // $user->last_name = $request->lName;
        // $user->email = $request->email;
        // $user->password = bcrypt($request->password);
        // $user->save();
        // return response()->json([
        //     'message' => 'Successfully created user!'
        // ], 201);
    }

    public function logout(Request $request)
    {
        // $request->user()->token()->revoke();
        // return response()->json([
        //     'message' => 'Successfully logged out'
        // ]);
    }

    public function user(Request $request)
    {
        // return response()->json($request->user());
    }
}