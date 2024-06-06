<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return [
        "id"=>$this->id,
        "title"=>$this->title,
        "description"=>$this->description,
        "due_date"=>$this->due_date,
        "status"=>$this->status,
        "assigned_to"=>$this->assignedTo?->name,
        "product_owner"=>$this->productOwner?->name,
        "sub_tasks"=>$this->subTasks,
        "logs"=>$this->logs,
        "created_at"=>$this->created_at,
        "updated_at"=>$this->updated_at,
      ];
    }
}
