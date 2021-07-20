<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_Line extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'priority'  => 'DESC',
        'name'      => 'ASC',
    ];

    protected $fillable = [
        'name',
        'brief',
        'priority',
    ];

    protected static $rules = [
        'name'      => [ 'required', 'min:4' ],
        'priority'  => [ 'sometimes', 'nullable', 'numeric', 'min:1' ],
    ];

}
