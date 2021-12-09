<?php

use HDSSolutions\Laravel\Http\Controllers\{
    BrandController,
    CategoryController,
    FamilyController,
    GamaController,
    LineController,
    ModelController,
    OptionController,
    SubFamilyController,
    TagController,
    TypeController,

    ProductController,
    VariantController,
    PriceListController,
    PriceListVersionController,

    ProductsImporterController,
};
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

    Route::resource('sub_families',     SubFamilyController::class, $name_prefix)
        ->parameters([ 'sub_families' => 'resource' ])
        ->name('index', 'backend.sub_families');

    Route::resource('categories',       CategoryController::class,  $name_prefix)
        ->parameters([ 'categories' => 'resource' ])
        ->name('index', 'backend.categories');

    Route::resource('tags',             TagController::class,       $name_prefix)
        ->parameters([ 'tags' => 'resource' ])
        ->name('index', 'backend.tags');

    Route::get('products/import',           [ ProductsImporterController::class, 'index' ])
        ->name('backend.products.import');
    Route::post('products/import',          [ ProductsImporterController::class, 'store' ]);
        // ->name('backend.products.import');
    Route::get('products/import/{import}',  [ ProductsImporterController::class, 'headers' ])
        ->name('backend.products.import.headers');
    Route::post('products/import/{import}', [ ProductsImporterController::class, 'process' ])
        ->name('backend.products.import.process');

    Route::get('products/search',           [ ProductController::class, 'search' ])
        ->name('backend.products.search');
    Route::resource('products',         ProductController::class,   $name_prefix)
        ->parameters([ 'products' => 'resource' ])
        ->name('index', 'backend.products');

    Route::resource('variants',         VariantController::class,   $name_prefix)
        ->parameters([ 'variants' => 'resource' ])
        ->name('index', 'backend.variants');

    Route::resource('price_lists',          PriceListController::class, $name_prefix)
        ->parameters([ 'price_lists' => 'resource' ])
        ->name('index', 'backend.price_lists');

    Route::resource('price_list_versions',  PriceListVersionController::class, $name_prefix)
        ->parameters([ 'price_list_versions' => 'resource' ])
        ->name('index', 'backend.price_list_versions');

});
