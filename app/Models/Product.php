<?php

namespace HDSSolutions\Finpar\Models;

use Illuminate\Database\Eloquent\Builder;

class Product extends X_Product {

    public function tax(float $discount = 0) {
        // check if tax is 0 (zero)
        if (in_array($this->taxRaw, [ 'ex', '05i', '10i' ])) return 0;
        // return product price plus tax
        return $this->price * ($this->taxRaw == '10' ? 0.10 : 0.05);
    }

    /* relations */

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function model() {
        return $this->belongsTo(Model::class);
    }

    public function family() {
        return $this->belongsTo(Family::class);
    }

    public function sub_family() {
        return $this->belongsTo(SubFamily::class);
    }

    public function line() {
        return $this->belongsTo(Line::class);
    }

    public function gama() {
        return $this->belongsTo(Gama::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class)
            ->using(ProductCategory::class)
            ->withTimestamps();
    }

    public function tags() {
        return $this->belongsToMany(Tag::class)
            ->using(ProductTag::class)
            ->withTimestamps();
    }

    public function images() {
        return $this->belongsToMany(File::class)
            ->using(ProductFile::class)
            ->withTimestamps();
    }

    public function storages() {
        return $this->hasMany(Storage::class)->ordered();
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
        return $this->belongsToMany(Currency::class, 'price_product')
            ->using(ProductPrice::class)
            ->withTimestamps()
            // only prices where product is set without variant
            ->wherePivotNull('variant_id')
            ->withPivot([ 'cost', 'price', 'limit', 'reseller' ]);
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

    public function scopeBuyable(Builder $query, bool $buyable = true) {
        return $query->whereHas('type', function($type) use ($buyable) {
            $type->sold($buyable);
        });
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
