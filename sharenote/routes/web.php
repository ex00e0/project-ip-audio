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
Route::get('/index/{page}', [AllController::class, 'index'])->name('paginate');
Route::get('/login', [AllController::class, 'show_login'])->name('show_login');
Route::post('/login', [AllController::class, 'login'])->name('login');
Route::get('/reg', [AllController::class, 'show_reg'])->name('show_reg');
Route::post('/reg', [AllController::class, 'reg'])->name('reg');
Route::get('/exit', [AllController::class, 'exit'])->name('exit');
Route::get('/lk', [AllController::class, 'show_lk'])->name('show_lk');
Route::post('/lk', [AllController::class, 'lk'])->name('lk');
Route::get('/sfs', [AllController::class, 'sfs'])->name('sfs');
Route::get('/forget_pass', [AllController::class, 'forget_pass'])->name('forget_pass');
Route::post('/forget_pass_db', [AllController::class, 'forget_pass_db'])->name('forget_pass_db');


Route::group(['middleware' => ['auth', 'CheckIsPerformer']], function()
{
Route::get('/performer_panel', [AllController::class, 'performer_panel'])->name('performer_panel');
Route::get('/performer_panel/{page}', [AllController::class, 'performer_panel'])->name('paginate_performer_panel');
Route::get('/sfs_performer_panel', [AllController::class, 'sfs_performer_panel'])->name('sfs_performer_panel');
Route::get('/edit_track/{id}', [AllController::class, 'edit_track'])->name('edit_track');
Route::post('/edit_track_db', [AllController::class, 'edit_track_db'])->name('edit_track_db');
Route::get('/create_track', [AllController::class, 'create_track'])->name('create_track');
Route::post('/create_track_db', [AllController::class, 'create_track_db'])->name('create_track_db');
Route::get('/delete_track/{id}', [AllController::class, 'delete_track'])->name('delete_track');

});

Route::group(['middleware' => ['auth', 'CheckIsAdmin']], function()
{
Route::get('/admin_panel', [AllController::class, 'admin_panel'])->name('admin_panel');
Route::get('/admin_panel/{page}', [AllController::class, 'admin_panel'])->name('paginate_admin_panel');
Route::get('/sfs_admin_panel', [AllController::class, 'sfs_admin_panel'])->name('sfs_admin_panel');
Route::get('/delete_track_admin/{id}', [AllController::class, 'delete_track_admin'])->name('delete_track_admin');

});


Route::get('/player', function () {
    return view('player');
});
