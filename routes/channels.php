<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//this channel allow users that already signed in to see the websocket updates
Broadcast::channel('import-task-progress.{id}', function ($user, $id) {
  //this condition can be change it to only product_owner can see the updates
  return true;
});

Broadcast::channel('task-expiry-alert.{id}', fn($user, $id) => $user->id == $id);