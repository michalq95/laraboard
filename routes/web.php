<?php

use App\Events\Chat;
use App\Events\ChatPrivateEvent;
use App\Events\Hello;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/broadcast', function () {
    // return view('welcome');
    Chat::dispatch("Hello");
    return "sent";
});
Route::get('/broadcastprivate', function () {
    // ChatPrivateEvent::dispatch("Hello");
    event(new ChatPrivateEvent(1, "Hello Privately"));
    return "sent privately";
});
