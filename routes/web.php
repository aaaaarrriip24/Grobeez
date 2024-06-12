<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\WelcomeController;

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

Route::get('/', [WelcomeController::class, 'index']);
Route::get('news/{id}', [WelcomeController::class, 'show']);

Route::group(['middleware' => 'prevent-back-history'],function(){
	Auth::routes([
        'register' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
    ]);
	Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Article
Route::get('articles', [ArticleController::class, 'index'])->name('articles');
Route::get('articles/{file}', [ArticleController::class, 'viewImage'])->name('image');
Route::post('articles', [ArticleController::class, 'store']);
Route::get('articles/{id}', [ArticleController::class, 'show']);
Route::post('articles/update', [ArticleController::class, 'update']);
Route::get('articles/destroy/{id}', [ArticleController::class, 'destroy']);