<?php

namespace MixCode\Http\Controllers\Api;

use MixCode\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MixCode\Http\Controllers\Controller;
use MixCode\Notifications\RegisterActivate;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'activation_token' => str_random(60)
        ]);

        $user->notify(new RegisterActivate($user));

        return response()->json([
            'message' => 'Successfully Created User!'
        ], Response::HTTP_CREATED);
    }

    public function registerActivate($token)
	{
	    $user = User::where('activation_token', $token)->first();
	
	    if (!$user) {
	        return response()->json([
	            'message' => 'This activation token is invalid.'
	        ], 404);
	    }

	    $user->update(['active' => true, 'activation_token' => '']);

	    return $user;
	}


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = $request->only(['email', 'password']);
        // we make this tow roles to validate them with the auth()->attempt() method
        $credentials['active'] = 1;
    	$credentials['deleted_at'] = null;

        if(! auth()->attempt($credentials)) 
        	return response()->json([ 'message' => 'Unauthorized' ], Response::HTTP_UNAUTHORIZED);

        $user = $request->user();
        
        $tokenResult = $user->createToken("Personal Access Token With Alaa");
        
        $token = $tokenResult->token;

        if ($request->remember_me) $token->expires_at = Carbon::now()->addWeeks(1);
        
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
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
