<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditoresController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('list_employees', [EditoresController::class,'index'])->name('list_employees');
Route::get('search_employee', [EditoresController::class,'show'])->name('search_employee');
Route::get('recharge', [EditoresController::class,'recharge'])->name('recharge');
Route::get('transfer', [EditoresController::class,'transfer'])->name('transfer');