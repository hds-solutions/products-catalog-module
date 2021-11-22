<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_Model extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
        'brand_id',
    ];

    protected static $rules = [
        'name'      => [ 'required', 'min:1' ],
        'brand_id'  => [ 'required' ],
    ];
}
