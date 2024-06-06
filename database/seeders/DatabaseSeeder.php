<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
          PermissionSeeder::class,
          UserSeeder::class,
          TaskSeeder::class,
//          LogSeeder::class
        ]);
    }
}
