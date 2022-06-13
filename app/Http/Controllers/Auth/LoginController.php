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




        $credentials = $request->only(['email', 'password']);
        print_r($request->input('email'));
        die;
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'fName' => 'required|string',
            'lName' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);
        $user = new User;
        $user->first_name = $request->fName;
        $user->last_name = $request->lName;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}