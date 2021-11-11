<?php

use App\Http\Controllers\Api\ApiPlaylistController;
use App\Http\Controllers\Api\ApiTrackController;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [\App\Http\Controllers\Api\PassportAuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Api\PassportAuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//  Playlist API Calls
Route::get('playlists/browse', [ApiPlaylistController::class, 'browse']);
Route::get('playlists/read/{id}', [ApiPlaylistController::class, 'read']);
Route::patch('playlists/edit/{playlist}', [ApiPlaylistController::class, 'edit']);
Route::post('playlists/add', [ApiPlaylistController::class, 'add']);
Route::delete('playlists/delete/{playlist}', [ApiPlaylistController::class, 'delete']);
Route::put('playlists/update_all/{playlist}', [ApiPlaylistController::class, 'update_all']);

// Track Api Calls
Route::get('tracks/browse', [ApiTrackController::class, 'browse']);
Route::get('tracks/read/{id}', [ApiTrackController::class, 'read']);
Route::patch('tracks/edit/{track}', [ApiTrackController::class, 'edit']);
Route::post('tracks/add', [ApiTrackController::class, 'add']);
Route::delete('tracks/delete/{id}', [ApiTrackController::class, 'delete']);
Route::put('tracks/update_all/{track}', [ApiTrackController::class, 'update_all']);


