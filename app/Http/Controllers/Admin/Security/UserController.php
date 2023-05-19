<?php

namespace App\Http\Controllers\Admin\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Security\UserCreateRequest;
use App\Http\Requests\Admin\Security\UserUpdateRequest;
use App\Http\Resources\Admin\Security\UserResource;
use App\Http\Resources\Admin\Security\UserUpdateResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();

        return customResponseSucessfull(
            __('generals.success-index', ['name' => 'Users']),
            UserResource::collection($users)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->merge([
                'password' => Hash::make($request->password)
            ]);
            $user = User::create($request->only(['name','email','password']));
            $user->assignRole($request->role_id);
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
    public function show(User $user)
    {
        $user->load('roles');
        return customResponseSucessfull(
            __('generals.success-show', ['name' => 'User']),
            UserResource::make($user)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $user->update($request->only(['name','email','password']));
            $user->roles()->sync([$request->role_id]);
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
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }

    public function restore(int $user)
    {
        $user = User::withTrashed()->find($user);
        $user->restore();

        return response()->noContent();
    }
}
