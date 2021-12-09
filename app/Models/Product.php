<?php

namespace HDSSolutions\Laravel\Models;

use Illuminate\Database\Eloquent\Builder;

class Product extends X_Product {

    // TODO: Implement with Currency
    public function tax(float $discount = 0) {
        // check if tax is 0 (zero)
        if (in_array($this->taxRaw, [ 'ex', '05i', '10i' ])) return 0;
        // return product price plus tax
        return $this->price * ($this->taxRaw == '10' ? 0.10 : 0.05);
    }

    /* relations */

    public function type() {
        return $this->belongsTo(Type::class)
            ->withTrashed();
    }

    public function brand() {
        return $this->belongsTo(Brand::class)
            ->withTrashed();
    }

    public function model() {
        return $this->belongsTo(Model::class)
            ->withTrashed();
    }

    public function family() {
        return $this->belongsTo(Family::class)
            ->withTrashed();
    }

    public function subFamily() {
        return $this->belongsTo(SubFamily::class)
            ->withTrashed();
    }

    public function line() {
        return $this->belongsTo(Line::class)
            ->withTrashed();
    }

    public function gama() {
        return $this->belongsTo(Gama::class)
            ->withTrashed();
    }

    public function categories() {
        return $this->belongsToMany(Category::class)
            ->using(ProductCategory::class)
            ->withTimestamps()
            ->withTrashed();
    }

    public function tags() {
        return $this->belongsToMany(Tag::class)
            ->using(ProductTag::class)
            ->withTimestamps()
            ->withTrashed();
    }

    public function images() {
        return $this->belongsToMany(File::class)
            ->using(ProductFile::class)
            ->withTimestamps()
            ->withTrashed();
    }

    public function storages() {
        return $this->hasMany(Storage::class)->ordered()
            ->withTrashed();
    }

    public function locators() {
        return $this->belongsToMany(Locator::class)
            ->using(ProductLocator::class)
            ->withTimestamps()
            // only locators where product is set without variant
            ->wherePivotNull('variant_id')
            ->withPivot([ 'active' ]);
    }

    public function prices() {
        return $this->belongsToMany(PriceListVersion::class, 'price_product')
            ->using(ProductPrice::class)
            ->withTimestamps()
            // only prices where product is set without variant
            ->wherePivotNull('variant_id')
            ->withPivot([ 'list', 'price', 'limit' ])
            ->as('price');
    }

    public function price(PriceList|int $priceList = null):?PriceListVersion {
        // return current price for specified priceList
        return $this->prices()
            // filter by specified PriceList
            ->of($priceList)
            // get valid prices only
            ->ordered()->valid()
            // get first
            ->first();
    }

    public function getPriceAttribute():?Currency {
        return $this->price();
    }

    public function getStockAttribute():int {
        // acumulator
        $qtyAvailable = 0;
        foreach ($this->storages as $storage) {
            // filter current branch
            if (($branch = session('branch')) && $storage->locator->warehouse && $storage->locator->warehouse->branch_id !== $branch->id) continue;
            //
            $qtyAvailable += $storage->available;
        }
        //
        return $qtyAvailable;
    }

    public function getStockableAttribute():bool {
        return $this->type->has_stock;
    }

    public function offers() {
        return $this->hasMany(Offer::class)
            // get active offers
            ->where([
                [ 'from', '<=', now()->toDateString() ],
                [ 'until', '>=', now()->toDateString() ]
            ])
            ->whereNull('variant_id')
            ->ordered();
    }

    public function offersRaw() {
        return $this->hasMany(Offer::class)
            // get active offers
            ->whereNull('variant_id')
            ->ordered();
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_lines');
    }

    public function variants() {
        return $this->hasMany(Variant::class);
    }

    /* scopes & filters */

    public static function code(string $code):?Product {
        // find resource by code
        return self::where('code', $code)->first();
    }

    public function scopeBuyable(Builder $query, bool $buyable = true) {
        return $query->whereHas('type', fn($type) => $type->isSold($buyable));
    }

    public function scopeStockable(Builder $query, bool $stockable = true) {
        return $query->whereHas('type', fn($type) => $type->hasStock($stockable));
    }

    public function scopeFilter(Builder $query, array $filters) {
        // foreach filters
        foreach ($filters as $filter => $values) {
            // check filter type
            switch ($filter) {
                //
            }
        }
        // return filtered query
        return $query;
    }

    public function scopeVisible(Builder $query) {
        return $query->where('visible', true);
    }

    public function scopeExpires(Builder $query) {
        return $query->whereHas('storages', function($storage) { return $storage->where('expire_at', '<', now()->addDays(7)); });
    }

}
