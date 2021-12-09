<?php

namespace HDSSolutions\Laravel\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Validator;

class PriceList extends X_PriceList {

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

    public function priceListVersions() {
        return $this->hasMany(PriceListVersion::class);
    }

    public function scopeIsPurchase(Builder $query, bool $is_purchase = true) {
        return $query->where('is_purchase', $is_purchase);
    }

    public function scopeIsSale(Builder $query, bool $is_sale = true) {
        return $this->scopeIsPurchase($query, !$is_sale);
    }

    protected function beforeSave(Validator $validator) {
        // check if the only PriceList (keeping sales/purchases separated)
        if (self::isPurchase( $this->is_purchase )->whereKeyNot( $this->id )->count() > 0) return;
        // force as default
        $this->is_default = true;
    }

    protected function afterSave() {
        // check if already set as default
        if (!$this->is_default) return;
        // update others PriceList (keeping sales/purchases separated)
        self::isPurchase( $this->is_purchase )
            // filter current PriceList
            ->whereKeyNot( $this->id )
            // remove default flag
            ->update([ 'is_default' => false ]);
    }

}
