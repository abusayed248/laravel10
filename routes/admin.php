<?php

use Illuminate\Support\Facades\Route;




Route::get('/admin-login', [\App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('admin.login');

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'is_admin'], function() {
    Route::get('/dashboard', 'AdminController@index')->name('home');
    Route::get('/logout', 'AdminController@logout')->name('logout');

    //category
    Route::resource('/category', CategoryController::class);
    Route::get('/category/delete/{category}', 'CategoryController@destroy')->name('category.destroy');

    //subcategory
    Route::resource('/subcategory', SubcategoryController::class);
    Route::get('/subcategory/delete/{subcategory}', 'SubcategoryController@destroy')->name('subcategory.destroy');

    //childcategory
    Route::resource('/childcategory', ChildcatController::class)->only(['index', 'create', 'store']);
    Route::get('/childcategory/edit/{childcat}', 'ChildcatController@edit')->name('childcategory.edit');
    Route::put('/childcategory/update/{childcat}', 'ChildcatController@update')->name('childcategory.update');
    Route::get('/childcategory/delete/{childcat}', 'ChildcatController@destroy')->name('childcategory.destroy');

    //brand
    Route::resource('/brand', BrandController::class);
    Route::get('/brand/delete/{brand}', 'BrandController@destroy')->name('brand.destroy');
    Route::get('/brand/inactive/{id}', 'BrandController@inActive')->name('brand.inactive');
    Route::get('/brand/active/{id}', 'BrandController@active')->name('brand.active');

    //pickup-points
    Route::resource('/pickup', PickupController::class);
    Route::get('/pickup/delete/{pickup}', 'PickupController@destroy')->name('pickup.destroy');

    //warehouses
    Route::resource('/warehouse', WarehouseController::class);
    Route::get('/warehouse/delete/{warehouse}', 'WarehouseController@destroy')->name('warehouse.destroy');

    //product route
    Route::resource('/product', ProductController::class);
    Route::get('/product/delete/{product}', 'ProductController@destroy')->name('product.destroy');
    Route::get('/get-child-category/{id}', 'ProductController@getChildcat')->name('getchildcat');

    //update status
    Route::group(['prefix' => 'product', 'as' => 'product.',], function() {
        Route::get('/status-active/{product}', 'ProductController@statusActive')->name('status.active');
        Route::get('/status-inactive/{product}', 'ProductController@statusInactive')->name('status.inactive');
    });

    //settings route
    Route::group(['prefix' => 'setting'], function() {
        Route::get('/edit', 'SettingController@edit')->name('edit.setting');
        Route::put('/update/{setting}', 'SettingController@update')->name('update.setting');
    });
});


