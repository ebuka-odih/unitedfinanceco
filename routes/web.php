<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', "HomepageController@home")->name('homepage');
//Route::get('/account/personal', "HomepageController@personal")->name('personal');
//Route::get('/account/business', "HomepageController@business")->name('business');

Route::view('/', 'pages.index')->name('homepage');
Route::view('/who-we-are', 'pages.who-we-are')->name('who-we-are');
Route::view('/contact-us', 'pages.contact-us')->name('contact-us');
Route::view('/business-banking', 'pages.business-banking')->name('business-banking');
Route::view('/business-banking/checking', 'pages.business-checking')->name('business.checking');
Route::view('/business-banking/savings', 'pages.business-savings')->name('business.savings');
Route::view('/business-banking/lending', 'pages.business-lending')->name('business.lending');

Route::view('/personal-banking', 'pages.personal-banking')->name('personal.banking');
Route::view('/personal-banking/checking', 'pages.personal-checking')->name('personal.checking');
Route::view('/personal-banking/savings', 'pages.personal-savings')->name('personal.savings');
Route::view('/personal-banking/lending', 'pages.personal-lending')->name('personal.lending');



Route::view('processing-info', 'pages.process-next-of-kin')->name('process_nok');
Route::get('next-of-kin', 'NextOfKinController@index')->name('next_of_kin');
Route::post('store/next-of-kin', 'NextOfKinController@store')->name('store.nok');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('dashboard', 'UserController@index')->name('dashboard');
        Route::get('transfer', 'WithdrawalController@transfer')->name('transfer');
        Route::get('transactions', 'WithdrawalController@transactions')->name('transactions');
        Route::get('profile', 'UserController@user_profile')->name('user_profile');
        Route::patch('{user}/update',  'UserController@update')->name('update');
        Route::get('kyc',  'UserController@kyc')->name('kyc');
        Route::post('kyc/store',  'UserController@kyc_store')->name('kyc_store');

//        Card Route
        Route::get('card', 'RequestCardController@card')->name('card');
        Route::post('store/card', 'RequestCardController@store')->name('card.store');

        Route::get('change-password', 'ChangePasswordController@index')->name('password.index');
        Route::post('change-password', 'ChangePasswordController@store')->name('change.password');

        //    messages route
        Route::get('messages', 'UserController@notifications')->name('messages');
        Route::get('read/messages', 'UserController@read')->name('read');
        Route::get('messages/{slug}', 'UserController@show_notify')->name('show_notify');

//        Withdrawal Route
        Route::get('transfer', 'TransactionsController@transfer')->name('transfer');
        Route::get('statement', 'TransactionsController@transactions')->name('statement');
        Route::post('transfer/store', 'TransactionsController@store')->name('store');
        Route::get('process-transaction/{id}', 'TransactionsController@process')->name('with_process');
        Route::get('transaction/details/dfzds{id}fyau343', 'TransactionsController@withdrawal_details')->name('withdrawal_details');

//        Code Request Route
        Route::get('process/atc/{id}', 'TransactionsController@atc_process')->name('atc_process');
        Route::get('secured/atc/fbnxr{id}454ew', 'TransactionsController@atc_code')->name('atc_code');
        Route::post('secured/atc-code', 'TransactionsController@atc_code_store')->name('atc_code_store');

        Route::get('process/otp/{id}', 'TransactionsController@otp_process')->name('otp_process');
        Route::get('secured/otp/fbnxr{id}454ew', 'TransactionsController@otp_code')->name('otp_code');
        Route::post('secured/otp-code', 'TransactionsController@otp_code_store')->name('otp_code_store');

        Route::get('process/trn/{id}', 'TransactionsController@trn_process')->name('trn_process');
        Route::get('secured/trn/fbnxr{id}454ew', 'TransactionsController@trn_code')->name('trn_code');
        Route::post('secured/trn-code', 'TransactionsController@trn_code_store')->name('trn_code_store');

//        Route::get('secured/otp/fbnxr{id}454ew', 'TransactionsController@otp_code')->name('otp_code');
//        Route::post('secured/otp-code', 'TransactionsController@otp_code_store')->name('otp_code_store');
//
//        Route::get('secured/trn/fbnxr{id}454ew', 'TransactionsController@trn_code')->name('trn_code');
//        Route::post('secured/otp-code', 'TransactionsController@trn_code_store')->name('trn_code_store');



//        Route::get('transaction/details/dfzds{id}fyau343', 'WithdrawalController@withdrawal_details')->name('withdrawal_details');
        Route::get('request-swift-code', 'WithdrawalController@request_swift_code')->name('request_swift_code');

});

include('admin.php');

