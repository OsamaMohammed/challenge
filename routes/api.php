<?php

use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\SnippetController;
use App\Http\Controllers\HomeController;
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

// Home routes
Route::get('/home/{type}', [HomeController::class, 'index'])->where('type', 'files|links|snippets');

// Files route
Route::resource('/files', FileController::class);
Route::post("/files", [FileController::class, 'store']);

// Links route
Route::resource('/links', LinkController::class);

// Snippets route
Route::resource('/snippets', SnippetController::class);
