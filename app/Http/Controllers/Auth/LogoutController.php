<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    public function __invoke()
    {
        Auth::logout();
        Log::info('usuario');
        Log::info(auth()->user());
        return response()->noContent();
    }
}
