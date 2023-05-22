<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Config\ExternalReferenceCreateRequest;
use App\Http\Requests\Admin\Config\ExternalReferenceUpdateRequest;
use App\Http\Resources\Admin\Config\ExternalReferenceResource;
use App\Models\ExternalReference;
use Exception;
use Illuminate\Support\Facades\DB;

class ExternalReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $externalReferences = ExternalReference::withTrashed()->get();

        return customResponseSucessfull(
            __('generals.success-index', ['name' => 'External Reference']),
            ExternalReferenceResource::collection($externalReferences)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExternalReferenceCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            ExternalReference::create($request->only(['name', 'url']));
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
    public function show(ExternalReference $externalReference)
    {
        return customResponseSucessfull(
            __('generals.success-show', ['name' => 'External Reference']),
            ExternalReferenceResource::make($externalReference)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExternalReferenceUpdateRequest $request, ExternalReference $externalReference)
    {
        DB::beginTransaction();
        try {
            $externalReference->update($request->only(['name', 'url']));
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
    public function destroy(ExternalReference $externalReference)
    {

        if ($externalReference->publications->count() === 0) {
            $externalReference->delete();
            return response()->noContent();
        }
        return customResponseError(
            422,
            __('generals.errors-validations.destroy', ['name' => 'Region']),
            __('generals.errors-validations.destroy', ['name' => 'Region']),
            422
        );
    }

    public function restore(int $externalReference)
    {
        $externalReference = ExternalReference::withTrashed()->find($externalReference);
        $externalReference->restore();

        return response()->noContent();
    }
}
