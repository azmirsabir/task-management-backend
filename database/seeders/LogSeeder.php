<?php

namespace Database\Seeders;

use App\Models\TaskLog;
use Illuminate\Database\Seeder;
class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      TaskLog::factory(10)->create();
    }
}
