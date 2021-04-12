<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_ProductPrice extends Base\Pivot {
    use BelongsToCompany;

    protected $table = 'price_product';

    protected $fillable = [
        'currency_id',
        'product_id',
        'variant_id',
        'cost',
        'price',
        'limit',
        'reseller',
    ];

    protected $casts = [
        'reseller'  => 'boolean',
    ];

    public function getCostAttribute():int|float {
        return $this->attributes['cost'] / pow(10, $this->currency->decimals);
    }

    public function setCostAttribute(int|float $cost) {
        $this->attributes['cost'] = $cost * pow(10, $this->currency->decimals);
    }

    public function getPriceAttribute():int|float {
        return $this->attributes['price'] / pow(10, $this->currency->decimals);
    }

    public function setPriceAttribute(int|float $price) {
        $this->attributes['price'] = $price * pow(10, $this->currency->decimals);
    }

    public function getLimitAttribute():int|float {
        return $this->attributes['limit'] / pow(10, $this->currency->decimals);
    }

    public function setLimitAttribute(int|float $limit) {
        $this->attributes['limit'] = $limit * pow(10, $this->currency->decimals);
    }

}
