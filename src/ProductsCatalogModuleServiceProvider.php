<?php

namespace HDSSolutions\Finpar;

use HDSSolutions\Laravel\Modules\ModuleServiceProvider;

class ProductsCatalogModuleServiceProvider extends ModuleServiceProvider {

    protected array $middlewares = [
        \HDSSolutions\Finpar\Http\Middleware\ProductsCatalogMenu::class,
    ];

    private array $commands = [
        // \HDSSolutions\Finpar\Commands\Mix::class,
    ];

    public function bootEnv():void {
        // enable config override
        $this->publishes([
            module_path('config/products-catalog.php') => config_path('products-catalog.php'),
        ], 'products-catalog.config');

        // load routes
        $this->loadRoutesFrom( module_path('routes/products-catalog.php') );
        // load views
        $this->loadViewsFrom( module_path('resources/views'), 'products-catalog' );
        // load translations
        $this->loadTranslationsFrom( module_path('resources/lang'), 'products-catalog' );
        // load migrations
        $this->loadMigrationsFrom( module_path('database/migrations') );
        // load seeders
        $this->loadSeedersFrom( module_path('database/seeders') );
    }

    public function register() {
        // register helpers
        if (file_exists($helpers = realpath(__DIR__.'/helpers.php')))
            //
            require_once $helpers;
        // register singleton
        app()->singleton('products-catalog', fn() => new ProductsCatalog);
        // register commands
        $this->commands( $this->commands );
        // merge configuration
        $this->mergeConfigFrom( module_path('config/products-catalog.php'), 'products-catalog' );
    }

}
