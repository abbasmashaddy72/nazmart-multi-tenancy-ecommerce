<?php

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

/* ------------------------------------------
     LANDLORD ADMIN ROUTES
-------------------------------------------- */
Route::group(['middleware' => ['auth:admin','adminglobalVariable', 'set_lang'],'prefix' => 'admin-home/webhook-manage'],function () {
    Route::resource("webhook",\Modules\WebHook\Http\Controllers\WebhookManageController::class)->only(['index','store','update','destroy']);
//    Route::post("new",[\Modules\WebHook\Http\Controllers\WebhookManageController::class,"store"])->name("landlord.webhook.manage.store");
////    Route::post("new",[\Modules\WebHook\Http\Controllers\WebhookManageController::class,"store_plugin"]);
//    Route::post("delete",[\Modules\WebHook\Http\Controllers\WebhookManageController::class,"delete_plugin"])->name("landlord.webhook.manage.delete");
//    Route::post("status",[\Modules\WebHook\Http\Controllers\WebhookManageController::class,"change_status"])->name("landlord.webhook.manage.status.change");
});
