<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_PriceListVersion extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'valid_from'    => 'DESC',
        'valid_until'   => 'DESC',
    ];

    protected $fillable = [
        'price_list_id',
        'name',
        'description',
        'valid_from',
        'valid_until',
    ];

}
