<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

define('PAGINATION_COUNT', 10);


/*
|--------------------------------------------------------------------------
| Authinticated Admins 
|--------------------------------------------------------------------------
|
| 
*/

Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    ## Languages Routes ##
    Route::group(['prefix' => 'languages'], function () {
        Route::get('/', [Admin\LanguagesController::class, 'index'])->name('admin.languages');
        Route::get('create', [Admin\LanguagesController::class, 'create'])->name('admin.languages.create');
        Route::post('store', [Admin\LanguagesController::class, 'store'])->name('admin.languages.store');
        Route::get('edit/{id}', [Admin\LanguagesController::class, 'edit'])->name('admin.languages.edit');
        Route::post('update/{id}', [Admin\LanguagesController::class, 'update'])->name('admin.languages.update');
        Route::get('delete/{id}', [Admin\LanguagesController::class, 'destroy'])->name('admin.languages.delete');
    });
    ## End Languages Routes ##

    ## Main Categories Routes ##
    Route::group(['prefix' => 'main_categories'], function () {
        Route::get('/', [Admin\MainCategoriesController::class, 'index'])->name('admin.maincategories');
        Route::get('create', [Admin\MainCategoriesController::class, 'create'])->name('admin.maincategories.create');
        Route::post('store', [Admin\MainCategoriesController::class, 'store'])->name('admin.maincategories.store');
        Route::get('edit/{id}', [Admin\MainCategoriesController::class, 'edit'])->name('admin.maincategories.edit');
        Route::post('update/{id}', [Admin\MainCategoriesController::class, 'update'])->name('admin.maincategories.update');
        Route::get('delete/{id}', [Admin\MainCategoriesController::class, 'destroy'])->name('admin.maincategories.delete');
        Route::get('delete/{id}', [Admin\MainCategoriesController::class, 'destroy'])->name('admin.maincategories.delete');
        Route::get('changeStatus/{id}', [Admin\MainCategoriesController::class, 'changeStatus'])->name('admin.maincategories.changeStatus');
    });
    ## End Main Categories Routes ##

    ## Vendors Routes ##
    Route::group(['prefix' => 'vendors'], function () {
        Route::get('/', [Admin\VendorsController::class, 'index'])->name('admin.vendors');
        Route::get('create', [Admin\VendorsController::class, 'create'])->name('admin.vendors.create');
        Route::post('store', [Admin\VendorsController::class, 'store'])->name('admin.vendors.store');
        Route::get('edit/{id}', [Admin\VendorsController::class, 'edit'])->name('admin.vendors.edit');
        Route::post('update/{id}', [Admin\VendorsController::class, 'update'])->name('admin.vendors.update');
        Route::get('delete/{id}', [Admin\VendorsController::class, 'destroy'])->name('admin.vendors.delete');
        Route::get('changeStatus/{id}', [Admin\VendorsController::class, 'changeStatus'])->name('admin.vendors.changeStatus');
    });
    ## End Vendors Routes ##
});



/*
|--------------------------------------------------------------------------
| Guest Admins 
|--------------------------------------------------------------------------
|
| 
*/


Route::group(['namespace' => 'Admin', 'middleware' => 'guest:admin'], function () {
    Route::get('login', [Admin\LoginController::class, 'getLogin'])->name('get.admin.login');
    Route::post('login', [Admin\LoginController::class, 'login'])->name('admin.login');
});
