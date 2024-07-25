<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CaseInformationController;

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

Route::get('/',[AuthController::class, 'index']);

Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    
});

/** allow all user role */
Route::group(['middleware' => 'auth'], function () {
	Route::get('/logout',[LoginController::class,'logout'])->name('logout');
	Route::get('/change-password',[LoginController::class,'changePassword'])->name('change-password');
	Route::post('/update-password',[LoginController::class,'updatePassword'])->name('update-password');
	

	Route::get('/my-profile',[UserProfileController::class,'myProfile'])->name('my-profile');
	Route::get('download/{id}',[CaseInformationController::class,'download']);
	Route::post('/my-profile-update',[UserProfileController::class,'update'])->name('my-profile-update');
	Route::post('/upload-my-profile-avata',[UserProfileController::class,'uploadMyPicture'])->name('upload-my-profile');
});

/** allow only role as user can use this link */
Route::group(['middleware' => ['auth','allow-role-user']], function () {
	
	Route::get('/user/search-cases',[CaseInformationController::class,'userSearchCase'])->name('user-search-case');
	Route::get('/user/case-information-show/{id}',[CaseInformationController::class,'userShowCase'])->name('user-case-information-show');
	Route::post('/user/case-information-search',[CaseInformationController::class,'userSearchCase'])->name('user-search-result-case-information');
});

/** allow only role as Admin can use this link */
Route::group(['middleware' => ['auth','allow-role-admin']], function () {
	Route::get('/user',[UserProfileController::class,'index'])->name('user-list');
	Route::get('/user-detail/{id}',[UserProfileController::class,'show'])->name('user-detail');
	Route::get('/user-edit/{id}/edit',[UserProfileController::class,'edit'])->name('user-edit');
	Route::get('/user/create',[UserProfileController::class,'create'])->name('user-create');
	Route::post('/user/store',[UserProfileController::class,'store'])->name('user-store');
	Route::post('/user-update',[UserProfileController::class,'update'])->name('user-update');
});

/** allow both role as Admin and Reporter */
Route::group(['middleware' => ['auth','allow-role-admin-reporter']], function () {
    Route::get('/dashboard',[LoginController::class,'dashboard'])->name('dashboard');
    
	/** none translate to khmer */
	Route::get('/case-information-search',[CaseInformationController::class,'search'])->name('search-case-information');
	Route::post('/case-information-search',[CaseInformationController::class,'searchResult'])->name('search-result-case-information');
	Route::get('/case-information',[CaseInformationController::class,'index'])->name('CaseList');
	Route::get('/case-information/create',[CaseInformationController::class,'create'])->name('case-information-create');
	Route::post('/case-information/store',[CaseInformationController::class,'store'])->name('case-information-store');
	Route::get('/case-information-show/{id}',[CaseInformationController::class,'show'])->name('case-information-show');
	Route::get('/case-information/{id}/edit',[CaseInformationController::class,'edit'])->name('case-information-edit');
	Route::post('/case-information-update',[CaseInformationController::class,'update'])->name('case-information-update');
	Route::post('/case-upload/delete-file',[CaseInformationController::class,'deletCaseUpload'])->name('case-upload-remove');

	/** translate to khmer */
	Route::post('/khmer-case-information/store',[CaseInformationController::class,'storeKhmerCase'])->name('khmer-case-information-store');
	Route::get('/case-information/create/khmer/case/{id}',[CaseInformationController::class,'createKhmerCase'])->name('create-khmer-case');
	Route::get('/khmer-case-information/{id}/edit',[CaseInformationController::class,'editKhmerCase'])->name('khmer-case-information-edit');
	Route::post('/khmer-case-information-update',[CaseInformationController::class,'updateKhmerCase'])->name('khmer-case-information-update');
});