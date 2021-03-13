<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;
use HDSSolutions\Finpar\Traits\BelongsToCompany;

class X_Variant extends Model {
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

    protected static $createRules = [
        'sku'           => [ 'required', 'min:2', 'unique:variants,sku,0,id,deleted_at,NULL' ],
        'stock_alert'   => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'priority'      => [ 'sometimes', 'nullable', 'min:0' ],
    ];

    protected static $updateRules = [
        'sku'           => [ 'required', 'min:2', 'unique:variants,sku,{id},id,deleted_at,NULL' ],
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
