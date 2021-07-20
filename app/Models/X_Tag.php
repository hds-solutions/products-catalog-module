<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_Tag extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'name'      => 'ASC',
    ];

    protected $fillable = [
        'name',
    ];

    protected static $rules = [
        'name'      => [ 'required', 'min:4' ],
    ];

}
