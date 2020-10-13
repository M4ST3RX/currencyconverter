<?php

use App\Http\Controllers\CurrencyConverterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CurrencyConverterController::class, 'index'])->name('home');

Route::get('/api/currencies', [CurrencyConverterController::class, 'api_currencies']);

Route::get('/favourites-and-history', [CurrencyConverterController::class, 'favouritesAndHistory'])->name('favourites-and-history');
