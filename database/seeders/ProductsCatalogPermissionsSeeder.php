<?php

namespace HDSSolutions\Laravel\Seeders;

class ProductsCatalogPermissionsSeeder extends Base\PermissionsSeeder {

    public function __construct() {
        parent::__construct('products-catalog');
    }

    protected function permissions():array {
        return [
            $this->resource('options'),
            $this->resource('types'),
            $this->resource('brands'),
            $this->resource('models'),
            $this->resource('lines'),
            $this->resource('gamas'),
            $this->resource('families'),
            $this->resource('sub_families'),
            $this->resource('categories'),
            $this->resource('tags'),
            $this->resource('products'),
            'products.process.*',
            'products.process.import' => 'Products import',
            $this->resource('variants'),
        ];
    }

    protected function afterRun():void {
        // append permissions to Depositor role
        $this->role('Depositor', [
            'options.*',
            'types.*',
            'brands.*',
            'models.*',
            'lines.*',
            'gamas.*',
            'families.*',
            'sub_families.*',
            'categories.*',
            'tags.*',
            'products.*',
            'products.process.*',
            'variants.*',
        ]);
    }

}
