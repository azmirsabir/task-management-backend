<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StatusTransition
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      $task = $request->route('task');
      $newStatus = $request->input('status');
      $currentStatus = $task->status;
      $roles = Auth::user()->getRoleNames();
      
      if(!$roles->contains('product_owner')) $this->validateUser($task);
      $this->validateStatusTransition($newStatus, $currentStatus);
      $this->validateRolePermissions($newStatus, $roles);
      
      return $next($request);
    }
    protected function validateUser($task)
    {
      if(Auth::user()->id!=$task->assigned_to){
        abort(400, "The user can not move the task");
      }
    }
  protected function validateStatusTransition(string $newStatus, string $currentStatus): void
  {
    $statusTransitions = [
      'TODO' => ['REJECTED', 'INPROGRESS'],
      'INPROGRESS' => ['REJECTED', 'READYFORTEST'],
      'READYFORTEST' => ['REJECTED', 'POREVIEW'],
      'POREVIEW' => ['REJECTED', 'DONE', 'INPROGRESS'],
    ];
    
    if (!isset($statusTransitions[$currentStatus])) {
      abort(400, "Invalid current status: $currentStatus");
    }
    
    if (!in_array($newStatus, $statusTransitions[$currentStatus])) {
      abort(400, "Cannot move task to $newStatus from $currentStatus");
    }
  }
  
  protected function validateRolePermissions(string $newStatus, $roles): void
  {
    if ($newStatus === 'REJECTED' && $roles->contains('product_owner')) {
      abort(400, "You will not be able to change the status to $newStatus");
    }
    
    if ($roles->contains('developer') && !in_array($newStatus, ['INPROGRESS', 'READYFORTEST'])) {
      abort(400, "You will not be able to change the status to $newStatus");
    }
    
    if ($roles->contains('tester') && $newStatus !== 'POREVIEW') {
      abort(400, "You will not be able to change the status to $newStatus");
    }
  }
}
