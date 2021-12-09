<?php

namespace HDSSolutions\Laravel\Models;

use Illuminate\Database\Eloquent\Builder;

class PriceListVersion extends X_PriceListVersion {

    public function priceList() {
        return $this->belongsTo(PriceList::class);
    }

    public function prices() {
        return $this->hasMany(ProductPrice::class);
    }

    public function scopeIsPurchase(Builder $query, bool $is_purchase = true) {
        return $query->whereHas('priceList', fn($priceList) => $priceList->IsPurchase($is_purchase));
    }

    public function scopeIsSale(Builder $query, bool $is_sale = true) {
        return $this->scopeIsPurchase($query, !$is_sale);
    }

    public function scopeValid(Builder $query) {
        // filter valid range
        return $query
            ->where('valid_from', '<', now())
            ->where(fn($until) => $until
                ->whereNull('valid_until')
                ->orWhere('valid_until', '>', now())
            );
    }

    public function scopeOf(Builder $query, PriceList|int $priceList) {
        // return versions of specified priceList
        return $query->where('price_list_id', $priceList instanceof PriceList ? $priceList->id : $priceList);
    }

}
