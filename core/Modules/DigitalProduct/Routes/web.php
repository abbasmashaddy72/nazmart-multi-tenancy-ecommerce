<?php

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

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
    /*-----------------------------------
        SHIPPING ROUTES
    ------------------------------------*/
    Route::group(['prefix' => 'digital-product'], function () {
        /*-----------------------------------
            DIGITAL PRODUCT TYPE ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'product-type', 'as' => 'admin.digital.product.type.'], function () {
            Route::get('/', 'DigitalProductTypeController@index')->name('all');
            Route::post('new', 'DigitalProductTypeController@store')->name('new');
            Route::post('update', 'DigitalProductTypeController@update')->name('update');
            Route::post('delete/{item}', 'DigitalProductTypeController@destroy')->name('delete');

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
    });
});
