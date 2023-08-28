<?php

use Illuminate\Support\Facades\Route;
use Modules\TaxModule\Http\Controllers\AdminTaxController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*-----------------------------------
            STATE TAX ROUTES
------------------------------------*/

Route::prefix('admin-home')->middleware(['setlang:backend', 'adminglobalVariable'])->group(function () {
    Route::prefix("tax-module")->as("admin.tax-module.")->group(function (){
        Route::get("settings", [AdminTaxController::class,"settings"])->name("settings");
        Route::put("settings", [AdminTaxController::class,"handleSettings"]);
        // todo:: those are class route
        Route::get("tax-class", [AdminTaxController::class,"taxClass"])->name("tax-class");
        Route::post("tax-class", [AdminTaxController::class,"handlePostTaxClass"]);
        Route::put("tax-class", [AdminTaxController::class,"handleTaxClass"]);
        Route::delete("tax-class", [AdminTaxController::class,"deleteTaxClass"])->name('tax-class-delete');
        // todo:: those are class option route
        Route::get("tax-class-option/{id}", [AdminTaxController::class,"taxClassOption"])->name("tax-class-option");
        Route::post("tax-class-option/{id}", [AdminTaxController::class,"handleTaxClassOption"])->name("tax-class-option");
//        Route::put("tax-class-option", [AdminTaxController::class,"handleTaxClassOption"]);
//        Route::delete("tax-class-option", [AdminTaxController::class,"deleteTaxClassOption"])->name('tax-class-option-delete');
    });

    /*-----------------------------------
        TAX ROUTES
    ------------------------------------*/
    Route::prefix('tax')->group(function () {


        /*-----------------------------------
            COUNTRY TAX ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'country', 'as' => 'admin.tax.country.'], function () {
            Route::get('/', 'CountryTaxController@index')->name('all');
            Route::post('new', 'CountryTaxController@store')->name('new');
            Route::post('update', 'CountryTaxController@update')->name('update');
            Route::post('delete/{item}', 'CountryTaxController@destroy')->name('delete');
            Route::post('bulk-action', 'CountryTaxController@bulk_action')->name('bulk.action');
        });
        /*-----------------------------------
            STATE TAX ROUTES
        ------------------------------------*/
        Route::group(['prefix' => 'state', 'as' => 'admin.tax.state.'], function () {
            Route::controller("StateTaxController")->group(function (){
                Route::get('/', 'index')->name('all');
                Route::post('new', 'store')->name('new');
                Route::post('update', 'update')->name('update');
                Route::post('delete/{item}', 'destroy')->name('delete');
                Route::post('bulk-action', 'bulk_action')->name('bulk.action');
                // Route::get('state-by-country', 'state_by_country')->name('by.country');
            });
        });
    });
});