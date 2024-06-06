<?php

namespace Database\Factories;

use App\Models\TaskLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LogFactory extends Factory
{
    protected $model=TaskLog::class;
    public function definition(): array
    {
      return [
        'task_id' => $this->faker->numberBetween(1, 10),
        'action' => $this->faker->randomElement(['Status Change', 'Title Change', 'Description Change']),
        'details' => $this->faker->sentence,
        'assigned_to'=>$this->faker->numberBetween(1, 10),
      ];
    }
}
