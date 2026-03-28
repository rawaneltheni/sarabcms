<?php

use Illuminate\Support\Facades\Route;

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('contact.store');

Route::get('/contact-us', function () {
    return redirect('/contact', 301);
});

Route::get('/', function () {
    return response()->file(public_path('frontend/index.html'));
});

Route::get('/{any}', function () {
    return response()->file(public_path('frontend/index.html'));
})->where('any', '^(?!api(?:/|$)|sarab(?:/|$)).*');
