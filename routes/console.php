<?php

use Illuminate\Support\Facades\Schedule;
Schedule::command('app:send-task-expiry-alert')->dailyAt("09:00");
