<?php

namespace HDSSolutions\Finpar\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class ProductsCatalogMenu {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        // create a submenu
        $sub = backend()->menu()
            ->add(__('products-catalog::nav'), [
                'icon'  => 'cogs',
            ])->data('priority', 900);

        $this
            // append items to submenu
            ->options($sub)
            ->types($sub)
            ->brands($sub)
            ->models($sub)
            ->lines($sub)
            ->gamas($sub)
            ->families($sub)
            ->subfamilies($sub)
            ->categories($sub)
            ->tags($sub)
            ->products($sub)
            ->variants($sub);

        // continue witn next middleware
        return $next($request);
    }

    private function options(&$menu) {
        if (Route::has('backend.options'))
            $menu->add(__('products-catalog::options.nav'), [
                'route'     => 'backend.options',
                'icon'      => 'options'
            ]);

        return $this;
    }

    private function types(&$menu) {
        if (Route::has('backend.types'))
            $menu->add(__('products-catalog::types.nav'), [
                'route'     => 'backend.types',
                'icon'      => 'types'
            ]);

        return $this;
    }

    private function brands(&$menu) {
        if (Route::has('backend.brands'))
            $menu->add(__('products-catalog::brands.nav'), [
                'route'     => 'backend.brands',
                'icon'      => 'brands'
            ]);

        return $this;
    }

    private function models(&$menu) {
        if (Route::has('backend.models'))
            $menu->add(__('products-catalog::models.nav'), [
                'route'     => 'backend.models',
                'icon'      => 'models'
            ]);

        return $this;
    }

    private function lines(&$menu) {
        if (Route::has('backend.lines'))
            $menu->add(__('products-catalog::lines.nav'), [
                'route'     => 'backend.lines',
                'icon'      => 'lines'
            ]);

        return $this;
    }

    private function gamas(&$menu) {
        if (Route::has('backend.gamas'))
            $menu->add(__('products-catalog::gamas.nav'), [
                'route'     => 'backend.gamas',
                'icon'      => 'gamas'
            ]);

        return $this;
    }

    private function families(&$menu) {
        if (Route::has('backend.families'))
            $menu->add(__('products-catalog::families.nav'), [
                'route'     => 'backend.families',
                'icon'      => 'families'
            ]);

        return $this;
    }

    private function subfamilies(&$menu) {
        if (Route::has('backend.subfamilies'))
            $menu->add(__('products-catalog::subfamilies.nav'), [
                'route'     => 'backend.subfamilies',
                'icon'      => 'subfamilies'
            ]);

        return $this;
    }

    private function categories(&$menu) {
        if (Route::has('backend.categories'))
            $menu->add(__('products-catalog::categories.nav'), [
                'route'     => 'backend.categories',
                'icon'      => 'categories'
            ]);

        return $this;
    }

    private function tags(&$menu) {
        if (Route::has('backend.tags'))
            $menu->add(__('products-catalog::tags.nav'), [
                'route'     => 'backend.tags',
                'icon'      => 'tags'
            ]);

        return $this;
    }

    private function products(&$menu) {
        if (Route::has('backend.products'))
            $menu->add(__('products-catalog::products.nav'), [
                'route'     => 'backend.products',
                'icon'      => 'products'
            ]);

        return $this;
    }

    private function variants(&$menu) {
        if (Route::has('backend.variants'))
            $menu->add(__('products-catalog::variants.nav'), [
                'route'     => 'backend.variants',
                'icon'      => 'variants'
            ]);

        return $this;
    }

}
