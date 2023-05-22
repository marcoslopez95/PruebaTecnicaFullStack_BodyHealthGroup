<?php

namespace App\Http\Controllers\Web\Writer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return \Inertia\Inertia::render('Writer/Publications/Index');

    }
}
