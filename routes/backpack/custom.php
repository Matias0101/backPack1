<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    // Ruta para Categorías - Solo accesible si el usuario tiene el permiso 'manage categories'
    Route::group(['middleware' => ['can:manage categories']], function () {
        Route::crud('category', 'CategoryCrudController');
    });
    // Rutas de productos con el middleware de permisos
    Route::group(['middleware' => ['can:manage products']], function () {
        Route::crud('product', 'ProductCrudController');
    });

    // Rutas de usuarios con el middleware de permisos
    Route::group(['middleware' => ['can:manage users']], function () {
        Route::crud('user', 'UserCrudController');
    });

    // Rutas de tags con el middleware de permisos
    Route::group(['middleware' => ['can:manage tags']], function () {
        Route::crud('tag', 'TagCrudController');
    });
});
