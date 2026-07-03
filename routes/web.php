<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\SentimentController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPortController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminCountryController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/countries', [CountryController::class, 'index'])
    ->middleware(['auth'])
    ->name('countries.index');

Route::get('/weather', [WeatherController::class,'index'])
    ->middleware(['auth'])
    ->name('weather.index');

Route::get('/currency', [CurrencyController::class, 'index'])
    ->middleware(['auth'])
    ->name('currency.index');

Route::get('/news', [NewsController::class, 'index'])
    ->middleware(['auth'])
    ->name('news.index');

Route::get('/ports', [PortController::class, 'index'])
    ->middleware(['auth'])
    ->name('ports.index');

Route::get('/comparison', [ComparisonController::class, 'index'])
    ->middleware('auth')
    ->name('comparison.index');

Route::get('/watchlist', [WatchlistController::class, 'index'])
    ->middleware('auth')
    ->name('watchlist.index');

Route::post('/watchlist', [WatchlistController::class, 'store'])
    ->middleware('auth')
    ->name('watchlist.store');

Route::delete('/watchlist/{watchlist}', [WatchlistController::class, 'destroy'])
    ->middleware('auth')
    ->name('watchlist.destroy');

Route::get('/sentiment', [SentimentController::class, 'index'])
    ->middleware('auth')
    ->name('sentiment.index');

Route::get('/risk', [RiskController::class, 'index'])
    ->middleware('auth')
    ->name('risk.index');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('auth')
    ->name('admin.index');

Route::post('/admin/recalculate-risk', [AdminController::class, 'recalculateRisk'])
    ->name('admin.recalculate');

Route::post('/admin/refresh-api', [AdminController::class, 'refreshApi'])
    ->name('admin.refresh');

Route::get('/admin/ports', [AdminPortController::class, 'index'])
    ->middleware('auth')
    ->name('admin.ports');

Route::post('/admin/ports', [AdminPortController::class, 'store'])
    ->middleware('auth')
    ->name('admin.ports.store');

Route::delete('/admin/ports/{port}', [AdminPortController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.ports.destroy');

Route::put('/admin/ports/{port}', [AdminPortController::class, 'update'])
    ->middleware('auth')
    ->name('admin.ports.update');

Route::get('/admin/ports/{port}/edit', [AdminPortController::class, 'edit'])
    ->middleware('auth')
    ->name('admin.ports.edit');

Route::get('/admin/articles', [AdminArticleController::class, 'index'])
    ->middleware('auth')
    ->name('admin.articles');

Route::post('/admin/articles', [AdminArticleController::class, 'store'])
    ->middleware('auth')
    ->name('admin.articles.store');

Route::delete('/admin/articles/{article}', [AdminArticleController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.articles.destroy');

Route::get('/admin/articles/{article}/edit', [AdminArticleController::class, 'edit'])
    ->middleware('auth')
    ->name('admin.articles.edit');

Route::put('/admin/articles/{article}', [AdminArticleController::class, 'update'])
    ->middleware('auth')
    ->name('admin.articles.update');

Route::get('/admin/users', [AdminUserController::class, 'index'])
    ->middleware('auth')
    ->name('admin.users');

Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.users.destroy');

Route::get('/admin/countries', [AdminCountryController::class, 'index'])
    ->middleware('auth')
    ->name('admin.countries');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
