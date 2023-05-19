<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Config\PublicationCategoryCreateRequest;
use App\Http\Requests\Admin\Config\PublicationCategoryUpdateRequest;
use App\Models\PublicationCategory;
use App\Http\Resources\Admin\Config\PublicationCategoryResource;
use Exception;
use Illuminate\Support\Facades\DB;

class PublicationCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publicationCategories = PublicationCategory::all();

        return customResponseSucessfull(
            __('generals.success-index', ['name' => 'Permission']),
            PublicationCategoryResource::collection($publicationCategories)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PublicationCategoryCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            PublicationCategory::create($request->only(['name', 'description']));
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
    public function show(PublicationCategory $publicationCategory)
    {
        return customResponseSucessfull(
            __('generals.success-show', ['name' => 'Permission']),
            PublicationCategoryResource::make($publicationCategory)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PublicationCategoryUpdateRequest $request, PublicationCategory $publicationCategory)
    {
        DB::beginTransaction();
        try {
            $publicationCategory->update($request->only(['name', 'description']));
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
    public function destroy(PublicationCategory $publicationCategory)
    {
        $publicationCategory->delete();

        return response()->noContent();
    }

    public function restore(int $publicationCategory)
    {
        $publicationCategory = PublicationCategory::withTrashed()->find($publicationCategory);
        $publicationCategory->restore();

        return response()->noContent();
    }
}
