<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwitterController;

/* Route::get('/', function () {
    return view('welcome');
});
Route::get('/twitter/tweets', [TwitterController::class, 'fetchTweets']); */

use App\Http\Controllers\YouTubeController;

Route::get('/', [YouTubeController::class, 'index'])->name('youtube.index');
Route::get('/search', [YouTubeController::class, 'search'])->name('youtube.search');
Route::get('/comments/{videoId}', [YouTubeController::class, 'getComments'])->name('youtube.comments');
