<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model=Task::class;
    public function definition(): array
    {
      return [
        'title' => $this->faker->sentence,
        'description' => $this->faker->paragraph,
        'assigned_to' => null,
        'created_by' => 1,
        'status' => 'TODO',
        'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        'parent_id' => null,
      ];
    }
}
