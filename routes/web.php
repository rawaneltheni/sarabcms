<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::view('/contact', 'contact')->name('contact');
Route::view('/contact-us', 'contact')->name('contact-us');
Route::post('/chatbot/message', [ChatbotController::class, 'message'])
	->middleware('throttle:20,1')
	->name('chatbot.message');
