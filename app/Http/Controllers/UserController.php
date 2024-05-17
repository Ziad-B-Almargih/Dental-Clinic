<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(): JsonResponse {
        $users = User::query()
            ->where('role_id', '!=', 1)
            ->get();

        return $this->success(UserResource::collection($users));
    }

    public function create(CreateUserRequest $request): JsonResponse{
        $data = $request->validated();
        $data['role_id'] = 2; // User role id is 2
        $data['password'] = Hash::make($data['password']);
        $user = User::query()
            ->create($data);
        if($request->has('permissions'))
            $user->permissions()->attach($data['permissions']);
        return $this->success(UserResource::make($user), 'created', 201);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse {
        $user->update($request->validated());

        if($request['permissions'])
            $user->permissions()->sync($request['permissions']);

        return $this->success(UserResource::make($user), 'updated');
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse {
        $data = $request->validated();
        $user = Auth::user();
        if(Hash::check($data['old_password'], $user['password'])){
            $data['new_password'] = Hash::make($data['new_password']);
            $user->update([
                'password' => $data['new_password'],
            ]);
            return $this->success(null, 'Password has been changed successfully');
        }

        return $this->failed('the password is wrong');
    }

    public function delete(User $user): JsonResponse{
        if($user['role'] == 'admin')
            return $this->failed('you cannot delete this account');
        $user->delete();

        return $this->noResponse();
    }
}
