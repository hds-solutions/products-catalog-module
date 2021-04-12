<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

class X_Offer extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'from'  => 'ASC',
    ];

    protected $fillable = [
        'product_id',
        'variant_id',
        'from',
        'until',
        'price',
    ];

    protected static $rules = [
        'product_id'    => [ 'required' ],
        'variant_id'    => [ 'sometimes', 'nullable' ],
        'from'          => [ 'required', 'date' ],
        'until'         => [ 'required', 'date' ],
        'price'         => [ 'required', 'numeric' ],
    ];

}
