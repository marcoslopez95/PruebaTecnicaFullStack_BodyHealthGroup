<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Config\RegionCreateRequest;
use App\Http\Requests\Admin\Config\RegionUpdateRequest;
use App\Http\Resources\Admin\Config\RegionResource;
use App\Models\Region;
use Exception;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::all();

        return customResponseSucessfull(
            __('generals.success-index', ['name' => 'Region']),
            RegionResource::collection($regions)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegionCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            Region::create($request->only(['name']));
        } catch (Exception $e) {
            DB::rollBack();
            return customResponseException($e, __('errors.sistem-error'), 500);
        }
        DB::commit();
        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $region)
    {
        return customResponseSucessfull(
            __('generals.success-show', ['name' => 'Region']),
            RegionResource::make($region)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegionUpdateRequest $request, Region $region)
    {
        DB::beginTransaction();
        try {
            $region->update($request->only(['name']));
        } catch (Exception $e) {
            DB::rollBack();
            return customResponseException($e, __('errors.sistem-error'), 500);
        }
        DB::commit();
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        //
    }
}
