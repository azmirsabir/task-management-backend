<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeTaskStatusRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Jobs\SendTaskAssignedEmail;
use App\Models\Task;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller implements HasMiddleware
{
    use ApiResponse;
    public static function middleware(): array
    {
      return [
        new Middleware('role:product_owner', only: ['store','update','destroy','assignTask']),
      ];
    }
    
    public function index(Request $request)
    {
      $tasks=Task::parentTasks()->search($request);
      orderByColumn($tasks,$request);
      $meta=addPagination($tasks,$request);
      return $this->jsonResponse(TaskResource::collection($tasks->get()),$meta);
    }
    
    public function store(TaskStoreRequest $request)
    {
      $validatedData = $request->validated();
      $validatedData['created_by'] = auth()->id();
      
      $task = Task::create($validatedData);
      return $this->jsonResponse(new TaskResource($task),null,"Task created successfully",Response::HTTP_CREATED);
    }
    
    public function show(Task $task)
    {
      return $this->jsonResponse(new TaskResource($task));
    }
    
    public function update(TaskUpdateRequest $request, Task $task)
    {
      $task->update($request->validated());
      return $this->jsonResponse(new TaskResource($task),null,"Task updated successfully");
    }
    
    public function destroy(Task $task)
    {
        $task->delete();
        return $this->jsonResponse(['message' => 'Task deleted successfully']);
    }
    public function assignTask(Task $task,User $user)
    {
      if(!$user->hasExactRoles('developer'))
        abort(403, "The user is not a developer");
      
        $task->update(['assigned_to'=>$user->id]);
        
        SendTaskAssignedEmail::dispatch($task);
        
        return $this->jsonResponse(['message' => 'Task '.$task->id.' assigned to user '.$user->name]);
    }
    public function changeTaskStatus(ChangeTaskStatusRequest $request,Task $task){
      $task->update(['status'=>$request->status]);
      return $this->jsonResponse(['message' => 'Task status has been moved to '.$request->status]);
    }
    public function importProgress($id)
    {
      return $this->jsonResponse(Bus::findBatch($id));
    }
}
