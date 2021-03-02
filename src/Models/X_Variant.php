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
        'price',
        'price_reseller',
        'priority',
    ];

    protected $casts = [
        'stock_alert'   => 'integer',
        'price'         => 'decimal:2',
        'price_reseller'=> 'decimal:2',
        'priority'      => 'integer',
    ];

    protected static $createRules = [
        'sku'           => [ 'required', 'min:2', 'unique:variants,sku,0,id,deleted_at,NULL' ],
        'stock_alert'   => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'price'         => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'price_reseller'=> [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'priority'      => [ 'sometimes', 'nullable', 'min:0' ],
    ];

    protected static $updateRules = [
        'sku'           => [ 'required', 'min:2', 'unique:variants,sku,{id},id,deleted_at,NULL' ],
        'stock_alert'   => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'price'         => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'price_reseller'=> [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'priority'      => [ 'sometimes', 'nullable', 'min:0' ],
    ];

    public function getPriceRawAttribute() {
        return $this->attributes['price'];
    }

    public function getPriceAttribute() {
        return $this->hasOffer ? $this->offer->price : ($this->attributes['price'] ?? $this->product->price);
    }

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
