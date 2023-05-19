<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Config\RegionCreateRequest;
use App\Http\Requests\Admin\Config\RegionUpdateRequest;
use App\Models\Region;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegionCreateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegionUpdateRequest $request, Region $region)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        //
    }
}
