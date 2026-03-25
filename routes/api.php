<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\BlogPostController;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\StatController;

use App\Http\Controllers\ChatbotController;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);

Route::get('/blog-posts', [BlogPostController::class, 'index']);
Route::get('/blog-posts/{blogPost}', [BlogPostController::class, 'show']);

Route::get('/abouts', [AboutController::class, 'index']);
Route::get('/abouts/{about}', [AboutController::class, 'show']);

Route::get('/stats', [StatController::class, 'index']);
Route::get('/stats/{stat}', [StatController::class, 'show']);

// Public chatbot endpoint (stateless, no CSRF)
Route::post('/chatbot/message', [ChatbotController::class, 'message'])
	->middleware('throttle:20,1')
	->name('chatbot.message');

Route::get('/customers', function () {
    return CustomerResource::collection(Customer::all());
});
