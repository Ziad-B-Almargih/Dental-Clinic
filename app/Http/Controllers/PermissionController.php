<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __invoke()
    {
        return $this->success(
            PermissionResource::collection(Permission::all())
        );
    }
}
