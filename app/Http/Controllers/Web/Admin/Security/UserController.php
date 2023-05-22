<?php

namespace App\Http\Controllers\Web\Admin\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return \Inertia\Inertia::render('Admin/Security/Users/Index');

    }
}
