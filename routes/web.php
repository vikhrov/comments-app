<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['web'])->group(function () {
    Route::prefix('comments')->as('comments.')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('index');
        Route::get('create', [CommentController::class, 'create'])->name('create');
        Route::post('store', [CommentController::class, 'store'])->name('store');
        Route::get('replies/{parentId}', [CommentController::class, 'getReplies'])->name('replies');
    });
});


