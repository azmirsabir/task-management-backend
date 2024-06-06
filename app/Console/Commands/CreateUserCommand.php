<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    protected $signature = 'make:user {name} {email} {password}';
    protected $description = 'Create a new user';
    
    /**
     * Execute the console command.
     */
    public function handle()
    {
      $name = $this->argument('name');
      $email = $this->argument('email');
      $password = $this->argument('password');
      
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->error('Invalid email address.');
        return 1;
      }
      
      if (User::where('email', $email)->exists()) {
        $this->error('User with this email already exists.');
        return 1;
      }
      
      $user = User::create([
        'name' => $name,
        'email' => $email,
        'password' => Hash::make($password),
      ]);
      
      $this->info("User {$name} created successfully!");
      
      return 0;
    }
}
