<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/api';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $name = 'John Doe';
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Pulled up the login method from AuthenticateUsers
     * extends the method to work with tokens
     *
     * @param Request $request
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()){
            return $this->errorWrongArgs('Wrong input', $this->parseErrors($validator));
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->sendLoginResponse($request, $token);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Pulled up the sendLoginResponse from AuthenticateUsers
     * extends it to work with tokens
     *
     * @param Request $request
     * @param string $token
     */
    protected function sendLoginResponse(Request $request, string $token)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user(), $token);
    }

    /**
     * Extends the authenticated mehtod with tokens
     *
     * @param Request $request
     * @param mixed $user
     * @param string $token
     */
    protected function authenticated(Request $request, $user, string $token)
    {
        return response()->json([
            'token' => $token,
        ]);
    }

    /**
     * Extends the sendFailedLoginResponse to work with tokens
     *
     * @param Request $request
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'message' => \Lang::get('auth.failed'),
        ], 401);
    }
        
}

