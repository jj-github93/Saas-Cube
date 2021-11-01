<?php

use App\Http\Controllers\Admin\PlaylistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Permission\RoleController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::prefix('admin')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('genres', App\Http\Controllers\Admin\GenreController::class);
    Route::resource('tracks', App\Http\Controllers\Admin\TrackController::class);
    Route::resource('playlists', App\Http\Controllers\Admin\PlaylistController::class);
});

//Route::patch('/admin/playlists/{playlist}/remove/{track}', PlaylistController::class)->name('playlists.remove');
Route::get('admin/playlists/{playlist}/remove/{track}', [PlaylistController::class, 'remove'])
    ->name('playlists.remove');

require __DIR__.'/auth.php';
