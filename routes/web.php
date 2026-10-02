<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\TweetLikeController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\BookmarkController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
     Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('follow.destroy');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    

    Route::get('/tweets/search', [TweetController::class, 'search'])
    ->name('tweets.search');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::resource('tweets', TweetController::class);

    Route::post('/tweets/{tweet}/like', [TweetLikeController::class, 'store'])
        ->name('tweets.like');

    Route::delete('/tweets/{tweet}/like', [TweetLikeController::class, 'destroy'])
        ->name('tweets.dislike');

    Route::get('/bookmarks', [BookmarkController::class, 'index'])
    ->name('bookmarks.index');
    
    Route::post('/tweets/{tweet}/bookmark', [BookmarkController::class, 'store'])
    ->name('tweets.bookmark');

    Route::delete('/tweets/{tweet}/bookmark', [BookmarkController::class, 'destroy'])
    ->name('tweets.unbookmark');

    Route::resource('tweets.comments', CommentController::class);
});

require __DIR__.'/auth.php';
