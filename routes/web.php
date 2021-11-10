<?php

use App\Http\Controllers\Admin\PlaylistController;
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
})->name('welcome');

Route::prefix('admin')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('genres', App\Http\Controllers\Admin\GenreController::class);
    Route::resource('tracks', App\Http\Controllers\Admin\TrackController::class);
    Route::resource('playlists', App\Http\Controllers\Admin\PlaylistController::class);
    Route::resource('roles', App\Http\Controllers\Permission\RoleController::class);

});

Route::get('admin/playlists/{playlist}/remove/{track}', [PlaylistController::class, 'remove'])
    ->name('playlists.remove');

Route::get('admin/role/{role}/remove/{permission}', [\App\Http\Controllers\Permission\RoleController::class, 'remove_permission'])
    ->name('roles.remove_permission');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
