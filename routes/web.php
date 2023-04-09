<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Resources\Json\ResourceResponse;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('posts.index');
    });
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/deleted', [PostController::class, 'deleted'])->name('posts.deleted');
    Route::get('/posts/{post:slug}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post:slug}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::patch('/posts/{post:slug}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post:slug})', [PostController::class, 'destroy'])->name('posts.destroy');
});



Route::get('github/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');

Route::get('github/auth/callback', function () {
    $githubUser = Socialite::driver('github')->user();
    $user = User::updateOrCreate([
        'github_id' => $githubUser->id,
    ], [
        'name' => $githubUser->name,
        'email' => $githubUser->email,
    ]);

    Auth::login($user);

    return redirect('/');
});


Route::get('google/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('login.google');

Route::get('google/auth/callback', function () {
    $googleUser = Socialite::driver('google')->user();
    $user = User::updateOrCreate([
        'google_id' => $googleUser->id,
    ], [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
    ]);

    Auth::login($user);

    return redirect('/');
});

// Route::resource('posts', [PostController::class]);

Auth::routes();
