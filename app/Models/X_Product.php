<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;
use HDSSolutions\Finpar\Traits\BelongsToCompany;

class X_Product extends Model {
    use BelongsToCompany;

    const TAXES = [
        'ex'    => 'Sin I.V.A.',
        '05'    => '5% extra',
        '05i'   => '5% incluido',
        '10'    => '10% extra',
        '10i'   => '10% incluido',
    ];

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
        'code',
        'url',
        'type_id',
        'brief',
        'description',
        'image_id',

        'brand_id',
        'model_id',
        'family_id',
        'sub_family_id',
        'line_id',
        'gama_id',

        'giftcard',
        'stock_alert',
        'tax',

        'weight',
        'length',
        'width',
        'height',

        'visible',
        'priority',
    ];

    protected $casts = [
        'giftcard'      => 'boolean',
        'stock_alert'   => 'integer',
        'weight'        => 'decimal:2',
        'length'        => 'decimal:2',
        'width'         => 'decimal:2',
        'height'        => 'decimal:2',
        'visible'       => 'boolean',
        'priority'      => 'integer',
    ];

    protected $attributes = [
        'giftcard'      => false,
        'visible'       => true,
        'tax'           => '10i',
    ];

    protected static $createRules = [
        'name'      => [ 'required', 'min:2' ],
        'code'      => [ 'sometimes', 'nullable', 'min:2' ],
        'url'       => [ 'sometimes', 'nullable', 'unique:products,url,0,id,deleted_at,NULL' ],
        'type_id'   => [ 'required' ],
        'brief'     => [ 'sometimes', 'nullable', 'min:5' ],
        'description'   => [ 'sometimes', 'nullable', 'min:5' ],

        'brand_id'  => [ 'sometimes', 'nullable' ],
        'model_id'  => [ 'sometimes', 'nullable' ],
        'family_id' => [ 'sometimes', 'nullable' ],
        'sub_family_id' => [ 'sometimes', 'nullable' ],
        'line_id'   => [ 'sometimes', 'nullable' ],
        'gama_id'   => [ 'sometimes', 'nullable' ],

        'giftcard'  => [ 'required', 'boolean' ],
        'stock_alert'   => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'tax'       => [ 'required', 'in:ex,05,10,05i,10i' ],

        'weight'    => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'length'    => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'width'     => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'height'    => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],

        'visible'   => [ 'sometimes', 'boolean' ],
        'priority'  => [ 'sometimes', 'nullable', 'min:0' ],
    ];

    protected static $updateRules = [
        'name'      => [ 'required', 'min:2' ],
        'code'      => [ 'sometimes', 'nullable', 'min:2' ],
        'url'       => [ 'sometimes', 'nullable', 'unique:products,url,{id},id,deleted_at,NULL' ],
        'type_id'   => [ 'sometimes' ],
        'brief'     => [ 'sometimes', 'nullable', 'min:5' ],
        'description'   => [ 'sometimes', 'nullable', 'min:5' ],

        'brand_id'  => [ 'sometimes', 'nullable' ],
        'model_id'  => [ 'sometimes', 'nullable' ],
        'family_id' => [ 'sometimes', 'nullable' ],
        'sub_family_id' => [ 'sometimes', 'nullable' ],
        'line_id'   => [ 'sometimes', 'nullable' ],
        'gama_id'   => [ 'sometimes', 'nullable' ],

        'giftcard'  => [ 'required', 'boolean' ],
        'stock_alert'   => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'tax'       => [ 'required', 'in:ex,05,10,05i,10i' ],

        'weight'    => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'length'    => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'width'     => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],
        'height'    => [ 'sometimes', 'nullable', 'numeric', 'min:0' ],

        'visible'   => [ 'sometimes', 'boolean' ],
        'priority'  => [ 'sometimes', 'nullable', 'min:0' ],
    ];

    /* Custom attributes accessors */

    public function getUrlRawAttribute() {
        // return raw value
        return $this->attributes['url'];
    }

    public function getUrlAttribute() {
        // return custom URL
        if ($this->url_raw !== null) return $this->url_raw;
        // return route
        return route('backend.products.show', $this);
    }

    public function getHasOfferAttribute() {
        return $this->offer !== null;
    }

    public function getHasOfferRawAttribute() {
        return $this->offerRaw !== null;
    }

    public function getHasVariantsAttribute() {
        return count($this->variants) > 0;
    }

    public function getOfferAttribute() {
        // find product offers
        return $this->offers->first();
    }

    public function getOfferRawAttribute() {
        // find product offers
        return $this->offersRaw->first();
    }

    public function getIsGiftCardAttribute() {
        return $this->giftcard == true;
    }

    public function getTaxAttribute() {
        // return tax price without discounts
        return $this->tax();
    }

    public function getTaxRawAttribute() {
        return $this->attributes['tax'];
    }

}
