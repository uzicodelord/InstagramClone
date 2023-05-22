<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome')->middleware('guest');

Auth::routes();
Route::middleware(['auth'])->group(function () {
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/posts', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts/{postId}', [PostController::class, 'show'])->name('posts.show');
Route::get('/explore', [PostController::class, 'index'])->name('posts.index');
Route::put('/posts/{postId}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{postId}', [App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy');
Route::post('/posts/{postId}/like', [LikeController::class, 'store'])->name('posts.like');
Route::post('/posts/{postId}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/{comment}/likes', [CommentLikeController::class, 'store'])->name('comment.likes.store');
Route::get('/{name}/', [ProfileController::class, 'show'])->name('profiles.show');
Route::put('/profiles', [ProfileController::class, 'update'])->name('profiles.update');
Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow');
Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('unfollow');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/direct/inbox', [ChatController::class, 'index'])->name('chats.index');
Route::post('/direct/inbox', [ChatController::class, 'store'])->name('chats.store');
Route::post('/direct/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
Route::get('/direct/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});
