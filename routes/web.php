<?php

use App\Http\Controllers\ChatsController;
use App\Http\Controllers\ProfileController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ChatsController::class, 'index'])->name('dashboard');
    Route::get('/chat', [ChatsController::class, 'chat'])->name('chat');
    Route::get('/messages/{id}', [ChatsController::class, 'messages'])->name('messages');
    Route::post('/messages/{id}', [ChatsController::class, 'createChat'])->name('createChat');
    Route::get('/backNotif/{sender_id}', [ChatsController::class, 'backNotif'])->name('backNotif');
    Route::post('/is-read', [ChatsController::class, 'isRead'])->name('isRead');
    Route::post('/is-seen', [ChatsController::class, 'isSeen'])->name('isSeen');
    Route::post('/is-deleted', [ChatsController::class, 'isDeleted'])->name('isDeleted');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
