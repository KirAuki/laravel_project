<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;



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


Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, "showRegistrationForm"])->name('register.form');
    Route::post('/register', [AuthController::class, "register"])->name('register');

    Route::get('/login', [AuthController::class, "showLoginForm"])->name('login.form');
    Route::post('/login', [AuthController::class, "login"])->name('login');
});

Route::middleware(['auth:sanctum', 'web'])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, "logout"])->name('logout');


    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/contact', function () {
        $contactData = [
            'email' => '123@example.com',
            'phone' => '123-456-789',
        ];

        return view('contact', compact('contactData'));
    })->name('contact');


    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
    Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');


    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::get('/comments', [CommentController::class, 'index'])->name('comments');
    Route::get('accept/{comment}', [CommentController::class, 'accept'])->name('comments.accept');
    Route::get('reject/{comment}', [CommentController::class, 'reject'])->name('comments.reject');
});
