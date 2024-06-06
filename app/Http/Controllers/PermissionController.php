<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    use ApiResponse;
    public static function middleware(): array
    {
      return [
        new Middleware('role:product_owner'),
      ];
    }
    
    public function permissions()
    {
        return $this->jsonResponse(PermissionResource::collection(Permission::all()));
    }
    
    public function roles()
    {
        return $this->jsonResponse(RoleResource::collection(Role::all()));
    }
    public function addRole(User $user,Role $role)
    {
        $user->assignRole($role);
        return $this->jsonResponse($user->getRoleNames());
    }
    public function removeRole(User $user,Role $role)
    {
      $user->removeRole($role);
      return $this->jsonResponse($user->getRoleNames());
    }
    public function addPermission(User $user, Permission $permission)
    {
        $user->givePermissionTo($permission);
        return $this->jsonResponse($user->getPermissionNames());
    }
    public function removePermission(User $user,Permission $permission)
    {
        $user->revokePermissionTo($permission);
        return $this->jsonResponse($user->getPermissionNames());
    }
}
