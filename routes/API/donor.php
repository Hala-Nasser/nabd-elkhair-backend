<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Donor\DonorController;
use App\Http\Controllers\Controller;

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
Route::get('donor/CampaignsAccordingToDonationType/{donation_type}',[DonorController::class, 'CampaignsAccordingToDonationType']);
Route::get('donor/CampaignsAccordingToCharity/{charity}',[DonorController::class, 'CampaignsAccordingToCharity']);
Route::get('donor/charities',[DonorController::class, 'charities']);
Route::get('donor/charity/search/{keyword}',[DonorController::class, 'charitySearch']);
Route::get('donor/profile/{id}',[DonorController::class, 'profile']);
Route::get('donor/mydonation/{id}/{donation_type}',[DonorController::class, 'myDonation']);
Route::post('donor/profile/update',[DonorController::class, 'updateProfile']);
Route::get('donor/donationtype', [DonorController::class, 'getDonationTypes']);
Route::get('donor/static/{id}', [DonorController::class, 'getStaticPages']);
Route::get('donor/notifications/{reciever_id}', [DonorController::class, 'getNotifications']);
Route::get('donor/donationtype/{id}', [DonorController::class, 'getDonationType']);
Route::get('donor/paymentLink/{charity_id}', [DonorController::class, 'getPaymentLink']);
Route::post('donor/enable/{id}', [DonorController::class, 'enableNotification']);
Route::post('donor/disable/{id}', [DonorController::class, 'disableNotification']);

// Route::post('donor/store/notification', [Controller::class, 'storeNoti']);

Route::group( ['prefix' => 'donor','middleware' => ['auth:donor-api','scopes:donor'] ],function(){
    // authenticated staff routes here 
    Route::post('addcomplaint', [DonorController::class,'addComplaint']);
    Route::post('addDonation', [DonorController::class,'addDonation']);
    Route::post('changePassword', [DonorController::class,'setNewAccountPassword']);
    Route::get('logout',[DonorController::class, 'logout']);

       
 });