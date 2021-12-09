<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_ProductPrice extends Base\Pivot {
    use BelongsToCompany;

    protected $table = 'price_product';

    protected $fillable = [
        'price_list_version_id',
        'product_id',
        'variant_id',
        'currency_id',
        'list',
        'price',
        'limit',
    ];

    protected function setKeysForSaveQuery($query) {
        // set composite key
        $query->where('price_list_version_id',  $this->attributes['price_list_version_id']);
        $query->where('product_id', $this->attributes['product_id']);
        if ($this->variant_id === null)
            $query->whereNull('variant_id');
        else
            $query->where('variant_id', $this->attributes['variant_id']);
        //
        return $query;
    }

    protected function getDeleteQuery() {
        //
        $query = $this->newQueryWithoutRelationships()->where([
            'price_list_version_id' => $this->attributes['price_list_version_id'],
            'product_id'            => $this->attributes['product_id'],
        ]);
        //
        if ($this->variant_id === null) $query->whereNull('variant_id');
        else $query->where('variant_id', $this->attributes['variant_id']);
        //
        return $query;
    }

    public function getListAttribute():int|float|null {
        return $this->attributes['list'] !== null ? $this->attributes['list'] / pow(10, $this->priceListVersion->priceList->currency->decimals) : null;
    }

    public function setListAttribute(int|float|null $list) {
        $this->attributes['list'] = $list !== null ? $list * pow(10, $this->priceListVersion->priceList->currency->decimals) : null;
    }

    public function getPriceAttribute():int|float {
        return $this->attributes['price'] / pow(10, $this->priceListVersion->priceList->currency->decimals);
    }

    public function setPriceAttribute(int|float $price) {
        $this->attributes['price'] = $price * pow(10, $this->priceListVersion->priceList->currency->decimals);
    }

    public function getLimitAttribute():int|float|null {
        return $this->attributes['limit'] !== null ? $this->attributes['limit'] / pow(10, $this->priceListVersion->priceList->currency->decimals) : null;
    }

    public function setLimitAttribute(int|float|null $limit) {
        $this->attributes['limit'] = $limit !== null ? $limit * pow(10, $this->priceListVersion->priceList->currency->decimals) : null;
    }

}
