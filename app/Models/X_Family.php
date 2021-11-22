<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_Family extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'priority'  => 'DESC',
        'name'      => 'ASC',
    ];

    protected $fillable = [
        'name',
        'priority',
    ];

    protected static $rules = [
        'name'  => [ 'required', 'min:1' ],
        'priority'  => [ 'sometimes', 'nullable', 'numeric', 'min:1' ],
    ];

}
