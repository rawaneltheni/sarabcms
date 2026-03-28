<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\BlogPostController;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\HomepageController;
use App\Http\Controllers\Api\PageBlockController;
use App\Http\Controllers\Api\StatController;
use App\Http\Controllers\Api\LegalPageController;
use App\Http\Controllers\Api\SiteSettingController;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Support\ApiCache;
use Illuminate\Support\Facades\Cache;

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::get('/homepage', [HomepageController::class, 'show']);

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);

Route::get('/blog-posts', [BlogPostController::class, 'index']);
Route::get('/blog-posts/{blogPost}', [BlogPostController::class, 'show']);

Route::get('/abouts', [AboutController::class, 'index']);
Route::get('/abouts/{about}', [AboutController::class, 'show']);

Route::get('/homes', [HomeController::class, 'index']);
Route::get('/homes/{home}', [HomeController::class, 'show']);

Route::get('/stats', [StatController::class, 'index']);
Route::get('/stats/{stat}', [StatController::class, 'show']);
Route::get('/page-blocks', [PageBlockController::class, 'index']);

Route::get('/site-settings', [SiteSettingController::class, 'show']);
Route::get('/legal-pages', [LegalPageController::class, 'index']);
Route::get('/legal-pages/{slug}', [LegalPageController::class, 'show']);

Route::get('/customers', function () {
    $customers = Cache::remember(ApiCache::key('customers:index'), now()->addMinutes(10), static function () {
        return Customer::query()
            ->select(['id', 'name', 'logo_path', 'website_url', 'order'])
            ->orderBy('order')
            ->orderBy('id')
            ->get();
    });

    return CustomerResource::collection($customers);
});
