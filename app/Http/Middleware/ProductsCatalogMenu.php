<?php

namespace HDSSolutions\Finpar\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class ProductsCatalogMenu extends Base\Menu {

    public function handle($request, Closure $next) {
        // create a submenu
        $sub = backend()->menu()
            ->add(__('products-catalog::catalog.nav'), [
                'icon'  => 'cogs',
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
        if (Route::has('backend.options') && $this->can('options'))
            $menu->add(__('products-catalog::options.nav'), [
                'route'     => 'backend.options',
                'icon'      => 'options'
            ]);

        return $this;
    }

    private function types(&$menu) {
        if (Route::has('backend.types') && $this->can('types'))
            $menu->add(__('products-catalog::types.nav'), [
                'route'     => 'backend.types',
                'icon'      => 'types'
            ]);

        return $this;
    }

    private function brands(&$menu) {
        if (Route::has('backend.brands') && $this->can('brands'))
            $menu->add(__('products-catalog::brands.nav'), [
                'route'     => 'backend.brands',
                'icon'      => 'brands'
            ]);

        return $this;
    }

    private function models(&$menu) {
        if (Route::has('backend.models') && $this->can('models'))
            $menu->add(__('products-catalog::models.nav'), [
                'route'     => 'backend.models',
                'icon'      => 'models'
            ]);

        return $this;
    }

    private function lines(&$menu) {
        if (Route::has('backend.lines') && $this->can('lines'))
            $menu->add(__('products-catalog::lines.nav'), [
                'route'     => 'backend.lines',
                'icon'      => 'lines'
            ]);

        return $this;
    }

    private function gamas(&$menu) {
        if (Route::has('backend.gamas') && $this->can('gamas'))
            $menu->add(__('products-catalog::gamas.nav'), [
                'route'     => 'backend.gamas',
                'icon'      => 'gamas'
            ]);

        return $this;
    }

    private function families(&$menu) {
        if (Route::has('backend.families') && $this->can('families'))
            $menu->add(__('products-catalog::families.nav'), [
                'route'     => 'backend.families',
                'icon'      => 'families'
            ]);

        return $this;
    }

    private function sub_families(&$menu) {
        if (Route::has('backend.sub_families') && $this->can('sub_families'))
            $menu->add(__('products-catalog::sub_families.nav'), [
                'route'     => 'backend.sub_families',
                'icon'      => 'sub_families'
            ]);

        return $this;
    }

    private function categories(&$menu) {
        if (Route::has('backend.categories') && $this->can('categories'))
            $menu->add(__('products-catalog::categories.nav'), [
                'route'     => 'backend.categories',
                'icon'      => 'categories'
            ]);

        return $this;
    }

    private function tags(&$menu) {
        if (Route::has('backend.tags') && $this->can('tags'))
            $menu->add(__('products-catalog::tags.nav'), [
                'route'     => 'backend.tags',
                'icon'      => 'tags'
            ]);

        return $this;
    }

    private function products(&$menu) {
        if (Route::has('backend.products') && $this->can('products'))
            $menu->add(__('products-catalog::products.nav'), [
                'route'     => 'backend.products',
                'icon'      => 'products'
            ]);

        return $this;
    }

    private function variants(&$menu) {
        if (Route::has('backend.variants') && $this->can('variants'))
            $menu->add(__('products-catalog::variants.nav'), [
                'route'     => 'backend.variants',
                'icon'      => 'variants'
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
