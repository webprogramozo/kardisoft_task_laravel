<?php

use App\Http\Controllers\KardisoftTask;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('/')->name('kardisoft.')->group(function (){
    Route::get('/', [KardisoftTask::class, 'list'])->name('list');
    Route::post('/search', [KardisoftTask::class, 'search'])->name('search');
    Route::post('/load-meds', [KardisoftTask::class, 'loadMeds'])->name('load-meds');
});
