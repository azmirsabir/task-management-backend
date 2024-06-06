<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller implements HasMiddleware
{
  use ApiResponse;
  public static function middleware(): array
  {
    return [
      new Middleware('role:product_owner', only: ['permissions','roles']),
    ];
  }
  public function login(LoginRequest $request)
  {
    $credentials = $request->validated();
    
    if(auth()->attempt($credentials)) {
      $user = auth()->user();
      $expires_at=Carbon::now()->addDay(1);
      $token=$user->createToken('authToken',['*'],$expires_at)->plainTextToken;
      return $this->jsonResponse(data:["token"=>$token,"user"=>$request->user()]);
    }
    return $this->error("Unauthorized", 401);
  }
  
  public function user()
  {
    return auth()->user();
  }
  
  public function logout(){
    auth()->user()->tokens()->delete();
    return $this->jsonResponse(["message"=>"successfully logged out"]);
  }
  
  public function permissions(){
    return Auth::user()->getPermissionNames();
  }
  
  public function roles(){
    return Auth::user()->getRoleNames();
  }
}
