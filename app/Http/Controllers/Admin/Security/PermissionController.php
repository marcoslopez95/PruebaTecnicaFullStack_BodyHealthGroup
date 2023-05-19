<?php

namespace App\Http\Controllers\Admin\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Security\PermissionCreateRequest;
use App\Http\Requests\Admin\Security\PermissionUpdateRequest;
use App\Http\Resources\Admin\Security\PermissionResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();

        return customResponseSucessfull(
            __('generals.success-index', ['name' => 'Permission']),
            PermissionResource::collection($permissions)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            Permission::create($request->only(['name', 'guard_name']));
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
    public function show(Permission $permission)
    {
        return customResponseSucessfull(
            __('generals.success-show', ['name' => 'Permission']),
            PermissionResource::make($permission)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        DB::beginTransaction();
        try {
            $permission->update($request->only(['name', 'guard_name']));
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
    public function destroy(Permission $permission)
    {
        if (self::validatePermissionsForDestroy($permission)) {
            return customResponseError(
                422,
                __('generals.errors-validations.destroy', ['name' => 'Role']),
                __('generals.errors-validations.destroy', ['name' => 'Role']),
                422,
            );
        }
        $permission->delete();

        return response()->noContent();
    }

    private function validatePermissionsForDestroy(Permission $permission): bool
    {
        $users = DB::table('role_has_permissions')
                ->select()
                ->where('permission_id', $permission->id)
                ->get()
                ->count() > 0;
        $permissions = DB::table('model_has_permissions')
                ->select()
                ->where('permission_id', $permission->id)
                ->get()
                ->count() > 0;

        return $users || $permissions;
    }
}
