<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Charity\CharityUserController;
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

Route::post('charity/register', [CharityUserController::class,'register']); //
Route::post('charity/login',[CharityUserController::class, 'login']); //
Route::post('charity/store/fcm', [CharityUserController::class,'storeFCMToken']); //
Route::post('charity/forgotPassword',[CharityUserController::class, 'forgotPassword']); //
Route::post('charity/resetPassword',[CharityUserController::class, 'resetPassword']); //
Route::get('charity/getCampaigns', [CharityUserController::class,'getCampaigns']); 
Route::get('charity/getDonationTypes', [CharityUserController::class,'getDonationTypes']); //
Route::get('charity/getCharityDonationTypes/{id}', [CharityUserController::class,'getCharityDonationTypes']);
Route::post('charity/addPaymentLinks', [CharityUserController::class,'addPaymentLinks']); //

Route::group( ['prefix' => 'charity','middleware' => ['auth:charity-api','scopes:charity'] ],function(){
    // authenticated staff routes here 
        Route::post('changePassword', [CharityUserController::class,'setNewAccountPassword']); //
        Route::post('addcomplaint', [CharityUserController::class,'addComplaint']);
        Route::post('addCampaign',[CharityUserController::class, 'addCampaign']);
        Route::post('setDonationAcceptance', [CharityUserController::class,'setDonationAcceptance']);
        Route::post('setDonationReceived', [CharityUserController::class,'setDonationReceived']);
        Route::post('updateProfile',[CharityUserController::class, 'updateProfile']); //
        Route::post('updateCampaign',[CharityUserController::class, 'updateCampaign']);

        Route::get('getPaymentLinks', [CharityUserController::class,'getPaymentLinks']); //
        Route::post('updatePaymentLinks', [CharityUserController::class,'updatePaymentLinks']); //
        Route::get('getCharity', [CharityUserController::class,'getCharity']); //
        Route::get('getComplaints', [CharityUserController::class,'getComplaints']);
        Route::get('getDonations', [CharityUserController::class,'getDonations']);
        Route::get('logout',[CharityUserController::class, 'logout']); //

        Route::delete('campaigns/{id}',[CharityUserController::class, 'deleteCampaign']);
        
       
 });