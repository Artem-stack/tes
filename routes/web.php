<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\RatingController;

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

Route::get('/', [ApiController::class, 'fetchData']);

Route::get('/countries/{country}', [RatingController::class, 'show'])->name('show');

Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

Route::put('/ratings/{id}', [RatingController::class, 'update'])->name('ratings.update');

Route::delete('/ratings/{id}', [RatingController::class, 'destroy'])->name('ratings.destroy');
