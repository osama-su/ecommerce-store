<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

define('PAGINATION_COUNT', 10);


Route::group(['namespace'=>'Admin','middleware'=>'auth:admin'],function(){
    Route::get('/',[Admin\DashboardController::class,'index'])->name('admin.dashboard');
    
    ## Languages Routes
    Route::group(['prefix'=>'languages'],function(){
        Route::get('/',[Admin\LanguagesController::class,'index'])->name('admin.languages');
        Route::get('create',[Admin\LanguagesController::class,'create'])->name('admin.languages.create');
        Route::post('store',[Admin\LanguagesController::class,'store'])->name('admin.languages.store');
    });
    ## End Languages Routes
});




Route::group(['namespace'=>'Admin','middleware'=>'guest:admin'],function(){
    Route::get('login',[Admin\LoginController::class,'getLogin'])->name('get.admin.login');
    Route::post('login',[Admin\LoginController::class,'login'])->name('admin.login');
});