<?php
  
  use App\Http\Controllers\AuthController;
  use App\Http\Middleware\StatusTransition;
  use App\Mail\TaskAssigned;
  use Illuminate\Support\Facades\Mail;
  use Illuminate\Support\Facades\Route;
  use App\Http\Controllers\UsersController;
  use App\Http\Controllers\PermissionController;
  use App\Http\Controllers\TaskController;
  use Illuminate\Mail\Message;
  
  
  Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
    Route::group(['middleware' => 'auth:sanctum'], function() {
      Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
      Route::get('permissions', [AuthController::class, 'permissions'])->name('auth.permissions');
      Route::get('roles', [AuthController::class, 'roles'])->name('auth.roles');
    });
  });
  
  Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('user', [AuthController::class, 'user'])->name('user');
    Route::ApiResource('task',TaskController::class);
    Route::ApiResource('users',UsersController::class);
    Route::post('task/{task}/{user}', [TaskController::class, 'assignTask'])->name('assignTask');
    Route::get('tasks/import-progress/{id}',[TaskController::class, 'importProgress'])->name('importProgress');
    Route::post('tasks/change-status/{task}', [TaskController::class, 'changeTaskStatus'])->name('changeTaskStatus')->middleware(StatusTransition::class);
    
    Route::group(['prefix' => 'permission'], function () {
      Route::get('/permissions',[PermissionController::class,'permissions'])->name('permissions');
      Route::get('/roles',[PermissionController::class,'roles'])->name('roles');
      Route::post('/add-role/{user}/{role}',[PermissionController::class,'addRole'])->name('addRole');
      Route::post('/remove-role/{user}/{role}',[PermissionController::class,'removeRole'])->name('removeRole');
      Route::post('/add-permission/{user}/{permission}',[PermissionController::class,'addPermission'])->name('addPermission');
      Route::post('/remove-permission/{user}/{permission}',[PermissionController::class,'removePermission'])->name('removePermission');
    });
  });
  

  


  


