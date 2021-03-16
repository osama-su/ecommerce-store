<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;



Route::group(['namespace'=>'Admin','middleware'=>'auth:admin'],function(){
    Route::get('/',[Admin\DashboardController::class,'index'])->name('admin.dashboard');
});




Route::group(['namespace'=>'Admin','middleware'=>'guest:admin'],function(){
    Route::get('login',[Admin\LoginController::class,'getLogin']);
    Route::post('login',[Admin\LoginController::class,'login'])->name('admin.login');
});