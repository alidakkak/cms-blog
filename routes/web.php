<?php

use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminContactMessageController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Front\FrontArticleController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\CommentController;
use Illuminate\Support\Facades\Route;

// ---------------- Public Routes ----------------

Route::get('/', [HomeController::class, 'index'])->name('home');

/**
 * Articles
 */
Route::get('/articles/{article}', [FrontArticleController::class, 'show'])
    ->name('article.show');

/**
 * Categories listing page
 */
Route::get('/categories/{category}', [FrontArticleController::class, 'category'])
    ->name('category.show');

/**
 * Contact
 */
Route::get('/contact', [ContactController::class, 'showForm'])
    ->name('contact.form');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

/**
 * Comments
 */
Route::middleware('auth')->post('/comments', [CommentController::class, 'store'])->name('comments.store');


// ---------------- Admin Routes ----------------

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::middleware('role:admin')->group(function () {

            Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

            ///////////// Categories
            Route::resource('categories', AdminCategoryController::class);

            ///////////// Comments
            Route::get('/comments', [AdminCommentController::class, 'index'])
                ->name('comments.index');
            Route::patch('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])
                ->name('comments.approve');
            Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])
                ->name('comments.destroy');

            //////////// Contact Messages
            Route::get('/contact-messages', [AdminContactMessageController::class, 'index'])
                ->name('contact-messages.index');

            Route::patch('/contact-messages/{contactMessage}/read', [AdminContactMessageController::class, 'markRead'])
                ->name('contact-messages.read');

            Route::patch('/contact-messages/{contactMessage}/unread', [AdminContactMessageController::class, 'markUnread'])
                ->name('contact-messages.unread');
        });
        Route::middleware('role:admin,editor')->group(function () {
            ///////////// Articles
            Route::resource('articles', AdminArticleController::class);
            Route::patch(
                'articles/{article}/toggle-status',
                [AdminArticleController::class, 'toggleStatus']
            )->name('articles.toggle-status');
        });
    });

require __DIR__ . '/auth.php';
