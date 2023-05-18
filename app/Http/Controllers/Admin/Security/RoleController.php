<?php

namespace App\Http\Controllers\Admin\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Security\RoleCreateRequest;
use App\Http\Requests\Admin\Security\RoleUpdateRequest;
use App\Http\Resources\Admin\Security\RoleResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        return customResponseSucessfull(
            __('generals.success-index', ['name' => 'Roles']),
            RoleResource::collection($roles)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            Role::create($request->only(['name', 'guard_name']));
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
    public function show(Role $role)
    {
        return customResponseSucessfull(
            __('generals.success-show', ['name' => 'Permission']),
            RoleResource::make($role)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        DB::beginTransaction();
        try {
            $role->update($request->only(['name', 'guard_name']));
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
    public function destroy(Role $role)
    {
        //
    }
}
