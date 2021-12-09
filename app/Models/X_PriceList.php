<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_PriceList extends Base\Model {
    use BelongsToCompany;

    protected array $orderBy = [
        'name',
    ];

    protected $fillable = [
        'currency_id',
        'name',
        'description',
        'is_purchase',
        'is_default',
    ];

    protected $casts = [
        'is_purchase'   => 'boolean',
        'is_default'    => 'boolean',
    ];

}
