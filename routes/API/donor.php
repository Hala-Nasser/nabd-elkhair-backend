<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Donor\DonorController;

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
Route::post('donor/register', [DonorController::class, 'register']);
Route::post('donor/login', [DonorController::class, 'login']);
Route::post('donor/store/fcm', [DonorController::class, 'storeFCMToken']);
Route::post('donor/forgotPassword',[DonorController::class, 'forgotPassword']);
Route::post('donor/resetPassword',[DonorController::class, 'resetPassword']);

Route::group( ['prefix' => 'donor','middleware' => ['auth:donor-api','scopes:donor'] ],function(){
    // authenticated staff routes here 
    Route::post('addcomplaint', [DonorController::class,'addComplaint']);
    Route::post('addDonation', [DonorController::class,'addDonation']);
    Route::post('changePassword', [DonorController::class,'setNewAccountPassword']);
    Route::get('logout',[DonorController::class, 'logout']);

       
 });