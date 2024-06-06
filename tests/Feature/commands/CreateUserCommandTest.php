<?php

namespace Tests\Feature\commands;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserCommandTest extends TestCase
{
  /** @test */
  public function it_creates_a_new_user()
  {
    $name = 'John Doe';
    $email = 'john@example.com';
    $password = 'secret';
    
    $this->artisan('make:user', [
      'name' => $name,
      'email' => $email,
      'password' => $password,
    ])
      ->expectsOutput("User {$name} created successfully!")
      ->assertExitCode(0);
    
    $this->assertDatabaseHas('users', [
      'name' => $name,
      'email' => $email,
    ]);
    
    $user = User::where('email', $email)->first();
    $this->assertTrue(Hash::check($password, $user->password));
  }
  
  /** @test */
  public function it_fails_if_email_is_invalid()
  {
    $name = 'John Doe';
    $email = 'invalid-email';
    $password = 'secret';
    
    $this->artisan('make:user', [
      'name' => $name,
      'email' => $email,
      'password' => $password,
    ])
      ->expectsOutput('Invalid email address.')
      ->assertExitCode(1);
  }
  
  /** @test */
  public function it_fails_if_user_already_exists()
  {
    $name = 'John Doe';
    $email = 'john@example.com';
    $password = 'secret';
    
    User::create([
      'name' => $name,
      'email' => $email,
      'password' => Hash::make($password),
    ]);
    
    $this->artisan('make:user', [
      'name' => $name,
      'email' => $email,
      'password' => $password,
    ])
      ->expectsOutput('User with this email already exists.')
      ->assertExitCode(1);
  }
}
