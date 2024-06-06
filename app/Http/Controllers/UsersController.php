<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\TaskLog;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller implements HasMiddleware
{
    use ApiResponse;
  
    public static function middleware(): array
    {
      return [
        new Middleware('role:product_owner'),
      ];
    }
    
    public function index(Request $request)
    {
      $users=User::query()->search($request);
      orderByColumn($users,$request);
      $meta=addPagination($users,$request);
      return $this->jsonResponse(UserResource::collection($users->get()),$meta);
    }
    
    public function store(UserRegisterRequest $request)
    {
        $user=User::create($request->validated());
        return $this->jsonResponse(new UserResource($user));
    }
    
    public function show(User $user)
    {
        $user=User::findOrFail($user->id);
        return $this->jsonResponse(new UserResource($user));
    }
    
    public function update(UserUpdateRequest $request, User $user)
    {
      $user->update($request->validated());
      return $this->jsonResponse(new UserResource($user));
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        return $this->jsonResponse(["message"=>"User deleted"]);
    }
}
