<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_Variant extends Base\Model {
    use BelongsToCompany;
    //

    protected $orderBy = [
        'sku'   => 'ASC',
    ];

    protected $fillable = [
        'product_id',
        'sku',
        'stock_alert',
        'priority',
    ];

    protected $casts = [
        'stock_alert'   => 'integer',
        'priority'      => 'integer',
    ];

    protected static $rules = [
        'sku'           => [ 'required', 'min:1', 'unique:variants,sku,{id},id,deleted_at,NULL' ],
        'stock_alert'   => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'priority'      => [ 'sometimes', 'nullable', 'min:0' ],
    ];

    public function getTaxAttribute() {
        // return tax price without discounts
        return $this->tax();
    }

    public function getHasOfferAttribute() {
        return $this->offer !== null;
    }

    public function getHasOfferRawAttribute() {
        return $this->offerRaw !== null;
    }

    public function getOfferAttribute() {
        // find product offers
        return $this->offers->first();
    }

    public function getOfferRawAttribute() {
        // find product offers
        return $this->offersRaw->first();
    }

    public function getUrlAttribute() {
        $url = [];
        foreach ($this->values as $value)
            $url[$value->option_id] = $value->option_value_id;
        return $url;
    }

}
