<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_Type extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
        'is_sold',
        'has_stock',
    ];

    protected $attributes = [
        'is_sold'   => true,
        'has_stock' => true,
    ];

    protected static $rules = [
        'name'      => [ 'required', 'min:4' ],
        'is_sold'   => [ 'required', 'boolean' ],
        'has_stock' => [ 'required', 'boolean' ],
    ];

}
