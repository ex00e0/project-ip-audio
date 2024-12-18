<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllController;

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

Route::get('/', [AllController::class, 'index'])->name('/');
Route::get('/login', [AllController::class, 'show_login'])->name('show_login');
Route::post('/login', [AllController::class, 'login'])->name('login');
Route::get('/reg', [AllController::class, 'show_reg'])->name('show_reg');
Route::post('/reg', [AllController::class, 'reg'])->name('reg');
Route::get('/exit', [AllController::class, 'exit'])->name('exit');

Route::get('/player', function () {
    return view('player');
});
