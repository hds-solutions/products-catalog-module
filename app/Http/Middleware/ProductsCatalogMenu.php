<?php

namespace HDSSolutions\Laravel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class ProductsCatalogMenu extends Base\Menu {

    public function handle($request, Closure $next) {
        // create a submenu
        $sub = backend()->menu()
            ->add(__('products-catalog::catalog.nav'), [
                'icon'  => 'dolly',
            ])->data('priority', 900);

        // get extras menu group
        $extras = backend()->menu()->get('extras');

        $this
            // append items to submenu
            ->options($sub)
            ->types($sub)
            ->brands($sub)
            ->models($sub)
            ->lines($sub)
            ->gamas($sub)
            ->families($sub)
            ->sub_families($sub)
            ->categories($sub)
            ->tags($sub)
            ->products($sub)
            ->variants($sub)

            ->products_importer($extras);

        // continue witn next middleware
        return $next($request);
    }

    private function options(&$menu) {
        if (Route::has('backend.options') && $this->can('options.crud.index'))
            $menu->add(__('products-catalog::options.nav'), [
                'route'     => 'backend.options',
                'icon'      => 'drafting-compass'
            ]);

        return $this;
    }

    private function types(&$menu) {
        if (Route::has('backend.types') && $this->can('types.crud.index'))
            $menu->add(__('products-catalog::types.nav'), [
                'route'     => 'backend.types',
                'icon'      => 'gifts'
            ]);

        return $this;
    }

    private function brands(&$menu) {
        if (Route::has('backend.brands') && $this->can('brands.crud.index'))
            $menu->add(__('products-catalog::brands.nav'), [
                'route'     => 'backend.brands',
                'icon'      => 'copyright'
            ]);

        return $this;
    }

    private function models(&$menu) {
        if (Route::has('backend.models') && $this->can('models.crud.index'))
            $menu->add(__('products-catalog::models.nav'), [
                'route'     => 'backend.models',
                'icon'      => 'magic'
            ]);

        return $this;
    }

    private function lines(&$menu) {
        if (Route::has('backend.lines') && $this->can('lines.crud.index'))
            $menu->add(__('products-catalog::lines.nav'), [
                'route'     => 'backend.lines',
                'icon'      => 'chess'
            ]);

        return $this;
    }

    private function gamas(&$menu) {
        if (Route::has('backend.gamas') && $this->can('gamas.crud.index'))
            $menu->add(__('products-catalog::gamas.nav'), [
                'route'     => 'backend.gamas',
                'icon'      => 'chess-bishop'
            ]);

        return $this;
    }

    private function families(&$menu) {
        if (Route::has('backend.families') && $this->can('families.crud.index'))
            $menu->add(__('products-catalog::families.nav'), [
                'route'     => 'backend.families',
                'icon'      => 'circle'
            ]);

        return $this;
    }

    private function sub_families(&$menu) {
        if (Route::has('backend.sub_families') && $this->can('sub_families.crud.index'))
            $menu->add(__('products-catalog::sub_families.nav'), [
                'route'     => 'backend.sub_families',
                'icon'      => 'chart-pie'
            ]);

        return $this;
    }

    private function categories(&$menu) {
        if (Route::has('backend.categories') && $this->can('categories.crud.index'))
            $menu->add(__('products-catalog::categories.nav'), [
                'route'     => 'backend.categories',
                'icon'      => 'grip-horizontal'
            ]);

        return $this;
    }

    private function tags(&$menu) {
        if (Route::has('backend.tags') && $this->can('tags.crud.index'))
            $menu->add(__('products-catalog::tags.nav'), [
                'route'     => 'backend.tags',
                'icon'      => 'tags'
            ]);

        return $this;
    }

    private function products(&$menu) {
        if (Route::has('backend.products') && $this->can('products.crud.index'))
            $menu->add(__('products-catalog::products.nav'), [
                'route'     => 'backend.products',
                'icon'      => 'box'
            ]);

        return $this;
    }

    private function variants(&$menu) {
        if (Route::has('backend.variants') && $this->can('variants.crud.index'))
            $menu->add(__('products-catalog::variants.nav'), [
                'route'     => 'backend.variants',
                'icon'      => 'barcode'
            ]);

        return $this;
    }

    private function products_importer(&$menu) {
        if (Route::has('backend.products.import') && $this->can('products.process.import'))
            $menu->add(__('products-catalog::products.import.nav'), [
                'route'     => 'backend.products.import',
                'icon'      => 'products'
            ]);

        return $this;
    }

}
