<?php

use App\Http\Controllers\Api\ApiGenreController;
use App\Http\Controllers\Api\ApiPlaylistController;
use App\Http\Controllers\Api\ApiTrackController;
use App\Http\Controllers\Api\ApiUserController;
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

// Genre Api Calls
Route::get('genres/browse', [ApiGenreController::class, 'browse']);
Route::get('genres/read/{id}', [ApiGenreController::class, 'read']);
Route::patch('genres/edit/{genre}', [ApiGenreController::class, 'edit']);
Route::post('genres/add', [ApiGenreController::class, 'add']);
Route::delete('genres/delete/{id}', [ApiGenreController::class, 'delete']);
Route::put('genres/update_all/{genre}', [ApiGenreController::class, 'update_all']);

// User Api Calls
Route::get('users/browse', [ApiUserController::class, 'browse']);
Route::get('users/read/{id}', [ApiUserController::class, 'read']);
Route::patch('users/edit/{user}', [ApiUserController::class, 'edit']);
Route::post('users/add', [ApiUserController::class, 'add']);
Route::delete('users/delete/{id}', [ApiUserController::class, 'delete']);
Route::put('users/update_all/{user}', [ApiUserController::class, 'update_all']);

