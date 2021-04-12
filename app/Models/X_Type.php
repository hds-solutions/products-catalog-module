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
        'sold',
    ];

    protected static $rules = [
        'name'  => [ 'required', 'min:4' ],
        'sold'  => [ 'required', 'boolean' ],
    ];

}
