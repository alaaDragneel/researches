<?php

namespace MixCode\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticateLogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }

    public function authenticateLogs()
    {
        return auth()->user()->authentications;
    }

    public function lastLoginAt()
    {
        return auth()->user()->lastLoginAt();
    }

    public function previousLoginAt()
    {
        return auth()->user()->previousLoginAt();
    }

    public function lastLoginIp()
    {
        return auth()->user()->lastLoginIp();
    }
}
