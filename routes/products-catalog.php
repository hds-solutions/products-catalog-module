<?php

use HDSSolutions\Finpar\Http\Controllers\BrandController;
use HDSSolutions\Finpar\Http\Controllers\CategoryController;
use HDSSolutions\Finpar\Http\Controllers\FamilyController;
use HDSSolutions\Finpar\Http\Controllers\GamaController;
use HDSSolutions\Finpar\Http\Controllers\LineController;
use HDSSolutions\Finpar\Http\Controllers\ModelController;
use HDSSolutions\Finpar\Http\Controllers\OptionController;
use HDSSolutions\Finpar\Http\Controllers\ProductController;
use HDSSolutions\Finpar\Http\Controllers\SubFamilyController;
use HDSSolutions\Finpar\Http\Controllers\TagController;
use HDSSolutions\Finpar\Http\Controllers\TypeController;
use HDSSolutions\Finpar\Http\Controllers\VariantController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'        => config('backend.prefix'),
    'middleware'    => [ 'web', 'auth:'.config('backend.guard') ],
], function() {
    // name prefix
    $name_prefix = [ 'as' => 'backend' ];

    Route::resource('types',            TypeController::class,      $name_prefix)
        ->parameters([ 'types' => 'resource' ])
        ->name('index', 'backend.types');

    Route::resource('options',          OptionController::class,    $name_prefix)
        ->parameters([ 'options' => 'resource' ])
        ->name('index', 'backend.options');

    Route::resource('brands',           BrandController::class,     $name_prefix)
        ->parameters([ 'brands' => 'resource' ])
        ->name('index', 'backend.brands');

    Route::resource('models',           ModelController::class,     $name_prefix)
        ->parameters([ 'models' => 'resource' ])
        ->name('index', 'backend.models');

    Route::resource('lines',            LineController::class,      $name_prefix)
        ->parameters([ 'lines' => 'resource' ])
        ->name('index', 'backend.lines');

    Route::resource('gamas',            GamaController::class,      $name_prefix)
        ->parameters([ 'gamas' => 'resource' ])
        ->name('index', 'backend.gamas');

    Route::resource('families',         FamilyController::class,    $name_prefix)
        ->parameters([ 'families' => 'resource' ])
        ->name('index', 'backend.families');

    Route::resource('subfamilies',      SubFamilyController::class, $name_prefix)
        ->parameters([ 'subfamilies' => 'resource' ])
        ->name('index', 'backend.subfamilies');

    Route::resource('categories',       CategoryController::class,  $name_prefix)
        ->parameters([ 'categories' => 'resource' ])
        ->name('index', 'backend.categories');

    Route::resource('tags',             TagController::class,       $name_prefix)
        ->parameters([ 'tags' => 'resource' ])
        ->name('index', 'backend.tags');

    Route::resource('products',         ProductController::class,   $name_prefix)
        ->parameters([ 'products' => 'resource' ])
        ->name('index', 'backend.products');

    Route::resource('variants',         VariantController::class,   $name_prefix)
        ->parameters([ 'variants' => 'resource' ])
        ->name('index', 'backend.variants');

});
