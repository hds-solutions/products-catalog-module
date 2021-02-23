<?php

use HDSSolutions\Finpar\Http\Controllers\BrandController;
use HDSSolutions\Finpar\Http\Controllers\ModelController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'        => config('backend.prefix'),
    'middleware'    => [ 'web', 'auth:'.config('backend.guard') ],
], function() {
    // name prefix
    $name_prefix = [ 'as' => 'backend' ];

    // Route::resource('companies',    CompanyController::class,   $name_prefix)
    //     ->parameters([ 'companies' => 'resource' ])
    //     ->name('index', 'backend.companies');

    Route::resource('brands',           BrandController::class, $name_prefix)
        ->parameters([ 'brands' => 'resource' ])
        ->name('index', 'backend.brands');
    Route::resource('models',           ModelController::class, $name_prefix)
        ->parameters([ 'models' => 'resource' ])
        ->name('index', 'backend.models');
    // Route::resource('families',
    //     'FamiliesController',   $name_prefix)->name('index', 'admin.families');
    // Route::resource('subfamilies',
    //     'SubFamiliesController',$name_prefix)->name('index', 'admin.subfamilies');
    // Route::resource('lines',
    //     'LinesController',      $name_prefix)->name('index', 'admin.lines');
    // Route::resource('gamas',
    //     'GamasController',      $name_prefix)->name('index', 'admin.gamas');
    // Route::resource('categories',
    //     'CategoriesController', $name_prefix)->name('index', 'admin.categories');
    // Route::resource('tags',
    //     'TagsController',       $name_prefix)->name('index', 'admin.tags');

    // Route::resource('options',
    //     'OptionsController',    $name_prefix)->name('index', 'admin.options');
    // Route::resource('types',
    //     'TypesController',      $name_prefix)->name('index', 'admin.types');

    // Route::resource('products',
    //     'ProductsController',   $name_prefix)->name('index', 'admin.products');
    // Route::resource('variants',
    //     'VariantsController',   $name_prefix)->name('index', 'admin.variants');

});