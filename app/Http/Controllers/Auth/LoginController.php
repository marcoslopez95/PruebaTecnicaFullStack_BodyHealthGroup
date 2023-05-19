<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

class LoginController extends Controller
{
    //

    public function __invoke(LoginRequest $request)
    {
        try {
            $user = User::firstWhere('email', $request->email);
            $check = Hash::check($request->password, $user->password);
            if (!$check) {
                throw new UnauthorizedException(__('auth.failed'), Response::HTTP_UNAUTHORIZED);
            }
            $tokenModel = $user->createToken('apiToken');
            Auth::login($user);
        } catch (UnauthorizedException $e) {
            return customResponseError(
                $e->getCode(),
                $e->getMessage(),
                $e->getMessage(),
                $e->getCode()
            );
        } catch (\Exception $e) {
            return customResponseException($e, __('errors.sistem-error'), 500);
        }
        DB::commit();
        return customResponseSucessfull(__('auth.login.successfull'), $tokenModel->plainTextToken);
    }
}
