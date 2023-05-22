<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Http\Requests\Writer\PublicationCreateRequest;
use App\Http\Requests\Writer\PublicationUpdateRequest;
use App\Http\Resources\Write\PublicationResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $publications = Publication::withTrashed(isAdmin())->with([
            'region',
            'publicationCategory',
            'externalReferences',
        ])->filter($request)->get();

        $publications = $request->paginated
            ? PublicationResource::collection($publications)->paginate($request->perPage ?? 15)
            : PublicationResource::collection($publications);
        return customResponseSucessfull(
            __('generals.success-index', ['name' => 'Publication']),
            $publications
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PublicationCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->merge(['user_id' => auth()->id()]);
            $publication = Publication::create($request->only([
                'content',
                'labels',
                'region_id',
                'publication_category_id',
                'user_id',
            ]));

            $publication->externalReferences()->attach($request->external_references);
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
    public function show(Publication $publication)
    {
        $publication->load([
            'region',
            'publicationCategory',
            'externalReferences',
        ]);
        return customResponseSucessfull(
            __('generals.success-show', ['name' => 'Publication']),
            PublicationResource::make($publication)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PublicationUpdateRequest $request, Publication $publication)
    {
        DB::beginTransaction();
        try {
            $request->merge(['user_id' => auth()->id()]);
            $publication->update($request->only([
                'content',
                'labels',
                'region_id',
                'publication_category_id',
                'user_id',
            ]));

            $publication->externalReferences()->sync($request->external_references);
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
    public function destroy(Publication $publication)
    {
        $publication->delete();

        return response()->noContent();
    }

    public function restore(int $publication)
    {
        $publication = Publication::withTrashed()->find($publication);
        $publication->restore();

        return response()->noContent();
    }
}
