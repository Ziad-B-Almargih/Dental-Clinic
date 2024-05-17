<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPassword\CheckResetPasswordRequest;
use App\Http\Requests\ResetPassword\ForgetPasswordRequest;
use App\Http\Requests\ResetPassword\ResetPasswordRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ResetPasswordServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct(
        private readonly ResetPasswordServices $resetPasswordServices
    )
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::query()->firstWhere('email', $data['email']);
        if(! Hash::check($data['password'], $user['password'])){
            return $this->failed('The password is wrong');
        }
        $token = $user->createToken(env('TOKEN_SECRET'))->plainTextToken;
        return $this->success([
            'token' => $token,
            'user'  => UserResource::make($user)
        ]);
    }

    public function logout() {
        Auth::user()->tokens()->delete();
    }

    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->resetPasswordServices->create($data['email']);

        return $this->success(null, 'We send the code via your email');
    }

    public function checkResetPassword(CheckResetPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();

        if($this->resetPasswordServices->check($data['email'], $data['code'])){
            return $this->success(null, 'The code is correct, Reset you password');
        }

        return  $this->failed('The code is invalid, Try again');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        if($this->resetPasswordServices->check($data['email'], $data['code'])){
            User::query()
                ->firstWhere('email', $data['email'])
                ->update([
                    'password' => Hash::make($data['password'])
                ]);

            $this->resetPasswordServices->delete($data['email']);

            return $this->success(null,'The new password is set successfully');
        }
        return  $this->failed('The code is invalid, Try again');
    }

}
