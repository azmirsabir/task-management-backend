<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\TaskLog;
use App\Models\User;
use App\TaskStatus;
class TaskObserver
{
    public function updated(Task $task): void
    {
      $previousStatus = $task->getOriginal('status');
      $newStatus = $task->status;
      
      $details="The task with id ".$task->id." has been updated";
      
      if($previousStatus!=$newStatus && $newStatus!=TaskStatus::REJECTED){
        Task::withoutEvents(function () use ($task, $newStatus, &$details) {
          if ($newStatus === TaskStatus::PO_REVIEW) {
            $task->assigned_to = $task->created_by;
            $details = "Status changed to " . $newStatus;
          } elseif ($newStatus == TaskStatus::READY_FOR_TEST) {
            $task->assigned_to = User::testerWithLessTask()->first()->id;
            $details = "Status changed to " . $newStatus;
          } elseif (in_array($newStatus, [TaskStatus::IN_PROGRESS, TaskStatus::DONE])) {
            $task->assigned_to = TaskLog::taskDeveloper($task->id)->first()->assigned_to;
            $details = "Status changed to " . $newStatus;
          }
          $task->save();
        });
      }
      
      $this->saveTaskLog($task,$details);
      
    }
    public function saveTaskLog($task,$details)
    {
      TaskLog::create([
        'task_id'=>$task->id,
        'action'=>"Task ".$task->id." has been updated",
        'details'=>$details,
        "assigned_to"=>$task->assigned_to
      ]);
    }
}
