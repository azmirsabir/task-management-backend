<?php

namespace Tests\Feature\controllers;

use App\Models\Task;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
  protected function setUp(): void
  {
    parent::setUp();
    $this->withoutMiddleware(ThrottleRequests::class);
  }
  public function test_index_method_returns_tasks()
  {
    Task::factory()->count(2)->create();
    $response = $this->getJson('/api/task');
    $response->assertOk();
  }
  
  public function test_assign_task()
  {
    Event::fake();
    $response = $this->postJson('/api/task/1/2');
    $response->assertOk();
  }
  
  public function test_change_task_status()
  {
    Event::fake();
    $attributes = Task::factory()->raw();
    $response = $this->postJson('api/tasks/change-status/2',$attributes);
    $response->assertOk();
  }
  
  public function test_index_params()
  {
    $perPage = 5;
    $this->getJson(route('/api/task', ['per_page' => $perPage]))
      ->assertOk()
      ->assertJsonCount($perPage, 'data');
  }
  
  public function test_model_not_found()
  {
    $this->getJson(route('/api/task', ['task' => 101]))
      ->assertNotFound();
  }
  
  public function test_store_task()
  {
    Event::fake();
    $attributes = Task::factory()->raw();
    $this->postJson('/api/task', $attributes)
      ->assertOk();
    
    $this->assertDatabaseHas('tasks', $attributes);
  }
  
  public function test_delete_task()
  {
    Event::fake();
    $this->deleteJson('api/task', ['task' => Task::first()->id])
      ->assertNoContent();
  }
}
