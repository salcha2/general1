<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('generals', GeneralController::class);
    $router->resource('panelsm', SmartMeterController::class);
    Route::get('generals/{id}', [GeneralController::class, 'edit'])->name('vendor.admin.edit');
    $router->resource('panelLVC', ConcentratorController::class);





});
