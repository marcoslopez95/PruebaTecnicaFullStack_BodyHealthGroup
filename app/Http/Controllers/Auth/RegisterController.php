<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->merge([
                'password' => Hash::make($request->password)
            ]);
            $user = User::create($request->only(['name', 'email', 'password']));
            $user->roles()->attach(Role::firstWhere('name', '=', 'User')->id);
        } catch (Exception $e) {
            DB::rollBack();
            return customResponseException($e, __('errors.sistem-error'), 500);
        }
        DB::commit();
        return response()->noContent();
    }
}
