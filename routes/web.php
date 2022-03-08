<?php

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

Auth::routes();
Route::get('/charity', [App\Http\Controllers\ControlPanel\Charity\CharityController::class, 'index'])->name('charity');
Route::get('charity/{id}', [App\Http\Controllers\ControlPanel\Charity\CharityController::class, 'details']);
Route::post('charity/enable/{id}', [App\Http\Controllers\ControlPanel\Charity\CharityController::class, 'enable']);
Route::post('charity/disable/{id}', [App\Http\Controllers\ControlPanel\Charity\CharityController::class, 'disable']);
Route::post('charity/delete/{id}', [App\Http\Controllers\ControlPanel\Charity\CharityController::class, 'destroy']);

Route::get('/donor', [App\Http\Controllers\ControlPanel\Donor\DonorController::class, 'index'])->name('donor');
Route::post('donor/enable/{id}', [App\Http\Controllers\ControlPanel\Donor\DonorController::class, 'enable']);
Route::post('donor/disable/{id}', [App\Http\Controllers\ControlPanel\Donor\DonorController::class, 'disable']);
Route::post('donor/delete/{id}', [App\Http\Controllers\ControlPanel\Donor\DonorController::class, 'destroy']);


Route::get('/donationtype', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'index'])->name('donationtype');
Route::get('donationtype/create', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'create']);
Route::post('donationtype/store', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'store']);
Route::post('donationtype/delete/{id}', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'destroy']);
Route::post('donationtype/restore/{id}', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'restore']);