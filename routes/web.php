<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/home', [App\Http\Controllers\ControlPanel\HomeController::class, 'index'])->name('home');

Auth::routes();
Route::get('/charity', [App\Http\Controllers\ControlPanel\Charity\CharityController::class, 'index'])->name('charity');
Route::get('charity/{id}', [App\Http\Controllers\ControlPanel\Charity\CharityController::class, 'details']);
Route::post('charity/enable/{id}', [App\Http\Controllers\ControlPanel\Charity\CharityController::class, 'enable']);
Route::post('charity/disable/{id}', [App\Http\Controllers\ControlPanel\Charity\CharityController::class, 'disable']);
Route::post('charity/delete/{id}', [App\Http\Controllers\ControlPanel\Charity\CharityController::class, 'destroy']);

Route::get('/donor', [App\Http\Controllers\ControlPanel\Donor\DonorController::class, 'index'])->name('donor');
Route::get('donor/{id}', [App\Http\Controllers\ControlPanel\Donor\DonorController::class, 'details']);
Route::post('donor/enable/{id}', [App\Http\Controllers\ControlPanel\Donor\DonorController::class, 'enable']);
Route::post('donor/disable/{id}', [App\Http\Controllers\ControlPanel\Donor\DonorController::class, 'disable']);
Route::post('donor/delete/{id}', [App\Http\Controllers\ControlPanel\Donor\DonorController::class, 'destroy']);

Route::get('/donationtype', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'index'])->name('donationtype');
Route::get('donationtype/create', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'create']);
Route::post('donationtype/store', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'store']);
Route::get('donationtype/edit/{id}', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'edit']);
// Route::post('donationtype/update/{id}', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'update']);
Route::post('donationtype/delete/{id}', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'destroy']);
Route::post('donationtype/restore/{id}', [App\Http\Controllers\ControlPanel\DonationType\DonationTypeController::class, 'restore']);

Route::get('/complaint', [App\Http\Controllers\ControlPanel\Complaint\ComplaintController::class, 'index'])->name('complaint');

Route::get('charity/donation/{id}', [App\Http\Controllers\ControlPanel\Donation\DonationController::class, 'index']);
Route::get('donor/donation/{id}', [App\Http\Controllers\ControlPanel\Donation\DonationController::class, 'donor']);

Route::get('static/{id}', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'index']);
Route::post('static/store/{id}', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'staticStore']);
// Route::post('onboarding/store/{id}', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'onboardingStore']);