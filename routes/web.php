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

Route::get('/home', [App\Http\Controllers\ControlPanel\HomeController::class, 'index'])->name('home');

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

Route::get('/complaint', [App\Http\Controllers\ControlPanel\Complaint\ComplaintController::class, 'index'])->name('complaint');

Route::get('charity/donation/{id}', [App\Http\Controllers\ControlPanel\Donation\DonationController::class, 'index']);

Route::get('about', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'aboutIndex']);
Route::post('about/store', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'aboutStore']);
Route::get('privacy', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'privacyIndex']);
Route::post('privacy/store', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'privacyStore']);
Route::get('onboarding1', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'onboarding1Index']);
Route::post('onboarding1/store', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'onboarding1Store']);
Route::get('onboarding2', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'onboarding2Index']);
Route::post('onboarding2/store', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'onboarding2Store']);
Route::get('onboarding3', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'onboarding3Index']);
Route::post('onboarding3/store', [App\Http\Controllers\ControlPanel\StaticPagesController::class, 'onboarding3Store']);