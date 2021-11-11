<?php

use App\Http\Controllers\Api\ApiPlaylistController;
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
Route::get('playlists/find/{id}', [ApiPlaylistController::class, 'find']);
Route::get('playlists/all', [ApiPlaylistController::class, 'all']);
Route::post('playlists/store', [ApiPlaylistController::class, 'store']);
Route::patch('playlists/edit/{playlist}', [ApiPlaylistController::class, 'edit']);
Route::put('playlists/update_all/{playlist}', [ApiPlaylistController::class, 'update_all']);
Route::delete('playlists/delete/{playlist}', [ApiPlaylistController::class, 'delete']);





