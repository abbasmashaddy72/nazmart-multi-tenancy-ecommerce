<?php

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Modules\DigitalProduct\Http\Controllers\CategoryBasedSubChildCategoryController;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    'auth:admin',
    'tenant_admin_glvar',
    'package_expire',
    'tenantAdminPanelMailVerify',
    'set_lang'
])->prefix('admin-home')->name('tenant.')->group(function () {
    Route::group(['prefix' => 'digital-product'], function () {
        /*-----------------------------------
            DIGITAL PRODUCT ROUTES
        ------------------------------------*/
        Route::group(['as' => 'admin.digital.product.'], function () {
            Route::get('/', 'DigitalProductController@index')->name('all');
            Route::get('create', 'DigitalProductController@create')->name('create');
            Route::post('new', 'DigitalProductController@store')->name('new');
            Route::post('update', 'DigitalProductController@update')->name('update');
            Route::post('delete/{item}', 'DigitalProductController@destroy')->name('delete');
            Route::post('bulk-action', 'DigitalProductController@bulk_action')->name('bulk.action');
        });

        /*-----------------------------------
            DIGITAL PRODUCT TYPE ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'product-type', 'as' => 'admin.digital.product.type.'], function () {
            Route::get('/', 'DigitalProductTypeController@index')->name('all');
            Route::post('new', 'DigitalProductTypeController@store')->name('new');
            Route::post('update', 'DigitalProductTypeController@update')->name('update');
            Route::post('delete/{item}', 'DigitalProductTypeController@destroy')->name('delete');
            Route::post('bulk-action', 'DigitalProductTypeController@bulk_action')->name('bulk.action');

            Route::post('type-based-extension', 'DigitalProductTypeController@typeBasedExtension')->name('extensions');
        });

        /*-----------------------------------
            DIGITAL PRODUCT CATEGORY ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'category', 'as' => 'admin.digital.product.category.'], function () {
            Route::get('/', 'DigitalProductCategoryController@index')->name('all');
            Route::post('new', 'DigitalProductCategoryController@store')->name('new');
            Route::post('update', 'DigitalProductCategoryController@update')->name('update');
            Route::post('delete/{item}', 'DigitalProductCategoryController@destroy')->name('delete');
            Route::post('bulk-action', 'DigitalProductCategoryController@bulk_action')->name('bulk.action');
        });

        /*-----------------------------------
            DIGITAL PRODUCT SUBCATEGORY ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'sub-category', 'as' => 'admin.digital.product.subcategory.'], function () {
            Route::get('/', 'DigitalProductSubCategoryController@index')->name('all');
            Route::post('new', 'DigitalProductSubCategoryController@store')->name('new');
            Route::post('update', 'DigitalProductSubCategoryController@update')->name('update');
            Route::post('delete/{item}', 'DigitalProductSubCategoryController@destroy')->name('delete');
            Route::post('bulk-action', 'DigitalProductSubCategoryController@bulk_action')->name('bulk.action');
        });

        /*-----------------------------------
            DIGITAL PRODUCT CHILD CATEGORY ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'child-category', 'as' => 'admin.digital.product.childcategory.'], function () {
            Route::get('/', 'DigitalProductChildCategoryController@index')->name('all');
            Route::post('new', 'DigitalProductChildCategoryController@store')->name('new');
            Route::post('update', 'DigitalProductChildCategoryController@update')->name('update');
            Route::post('delete/{item}', 'DigitalProductChildCategoryController@destroy')->name('delete');
            Route::post('bulk-action', 'DigitalProductChildCategoryController@bulk_action')->name('bulk.action');

            Route::post('category-based-subcategory', 'DigitalProductChildCategoryController@categoryBasedSubcategory')->name('category.based.subcategory');
        });

        /*-----------------------------------
            DIGITAL PRODUCT AUTHOR ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'author', 'as' => 'admin.digital.product.author.'], function () {
            Route::get('/', 'DigitalAuthorController@index')->name('all');
            Route::post('new', 'DigitalAuthorController@store')->name('new');
            Route::post('update', 'DigitalAuthorController@update')->name('update');
            Route::post('delete/{item}', 'DigitalAuthorController@destroy')->name('delete');
            Route::post('bulk-action', 'DigitalAuthorController@bulk_action')->name('bulk.action');
        });

        /*-----------------------------------
            DIGITAL PRODUCT TAX ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'tax', 'as' => 'admin.digital.product.tax.'], function () {
            Route::get('/', 'DigitalTaxController@index')->name('all');
            Route::post('new', 'DigitalTaxController@store')->name('new');
            Route::post('update', 'DigitalTaxController@update')->name('update');
            Route::post('delete/{item}', 'DigitalTaxController@destroy')->name('delete');
            Route::post('bulk-action', 'DigitalTaxController@bulk_action')->name('bulk.action');
        });

        /*-----------------------------------
            METHOD ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'method', 'as' => 'admin.shipping.method.'], function () {
            Route::get('/', 'ShippingMethodController@index')->name('all');
            Route::get('new', 'ShippingMethodController@create')->name('new');
            Route::post('new', 'ShippingMethodController@store');
            Route::get('edit/{item}', 'ShippingMethodController@edit')->name('edit');
            Route::post('update', 'ShippingMethodController@update')->name('update');
            Route::post('delete/{item}', 'ShippingMethodController@destroy')->name('delete');
            Route::post('bulk-action', 'ShippingMethodController@bulk_action')->name('bulk.action');
            Route::post('make-default', 'ShippingMethodController@makeDefault')->name('make.default');
        });


        /*==============================================
                    Product Module Category Route
        ==============================================*/
        Route::prefix("category")->as("admin.digital.category.")->group(function (){
            Route::controller(CategoryBasedSubChildCategoryController::class)->group(function (){
                Route::post("category","getCategory")->name("all");
                Route::post("sub-category","getSubCategory")->name("sub-category");
                Route::post("child-category","getChildCategory")->name("child-category");
            });
        });
    });
});
