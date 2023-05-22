<?php

namespace App\Http\Controllers\Web\Admin\Config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicationCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return \Inertia\Inertia::render('Admin/Config/PublicationCategories/Index');

    }
}
