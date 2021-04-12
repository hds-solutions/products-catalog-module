<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

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

    protected static $createRules = [
        'name'  => [ 'required', 'min:4' ],
        'priority'  => [ 'sometimes', 'nullable', 'numeric', 'min:1' ],
    ];

    protected static $updateRules = [
        'name'  => [ 'required', 'min:4' ],
        'priority'  => [ 'sometimes', 'nullable', 'numeric', 'min:1' ],
    ];

}
