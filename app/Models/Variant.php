<?php

namespace HDSSolutions\Laravel\Models;

class Variant extends X_Variant {

    // TODO: Implement Currency on tax()
    public function tax(float $discount = 0) {
        // check if tax is 0 (zero)
        if (in_array($this->product->taxRaw, [ 'ex', '05i', '10i' ])) return 0;
        // return product price plus tax
        return ($this->price - $discount) * ($this->product->taxRaw == '10' ? 0.10 : 0.05);
    }

    public function product() {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function values() {
        return $this->hasMany(VariantValue::class);
    }

    public function offers() {
        return $this->hasMany(Offer::class)
            // get active offers
            ->where([
                [ 'from', '<=', now()->toDateString() ],
                [ 'until', '>=', now()->toDateString() ]
            ])->ordered();
    }

    public function offersRaw() {
        return $this->hasMany(Offer::class)
            // get active offers
            ->ordered();
    }

    public function images() {
        return $this->belongsToMany(File::class)
            ->using(VariantFile::class)
            ->withTimestamps();
    }

    public function storages() {
        return $this->hasMany(Storage::class)
            ->whereNotNull('product_id')
            ->ordered();
    }

    public function locators() {
        return $this->belongsToMany(Locator::class, 'locator_product')
            ->using(ProductLocator::class)
            ->withTimestamps()
            ->withPivot([ 'active' ]);
    }

    public function prices() {
        return $this->belongsToMany(Currency::class, 'price_product')
            ->using(ProductPrice::class)
            ->withTimestamps()
            ->withPivot([ 'cost', 'price', 'limit', 'reseller' ]);
    }

    public function price(Currency|int $currency = null):?Currency {
        // return price for specified currency
        return $this->prices()->firstWhere('currency_id', $currency instanceof Currency ? $currency->id : $currency);
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

}
