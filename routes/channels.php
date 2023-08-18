<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});



# to use private channel 

// Broadcast::routes(['middleware' => 'auth:sanctum']); // Use the 'auth:sanctum' middleware

// Broadcast::channel('private-channel', function ($user) {
//     return Auth::check() ? ['id' => $user->id, 'name' => $user->name] : null;
// });