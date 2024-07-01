<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CateogryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => 'auth',
        'middleware' => 'api'
    ],
    function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('me', [AuthController::class, 'me'])->name('me');
    }
);

Route::resource('posts', PostsController::class);
Route::post('upload_update_image', [PostsController::class, 'uploadUpdateImage'])->name('uploadUpdateImage');



Route::get('my-posts', [PostsController::class, 'myPosts'])->name('myPosts');

Route::resource('categories', CateogryController::class);

