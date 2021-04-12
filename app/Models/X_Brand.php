<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Models\File;
use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_Brand extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'priority'  => 'DESC',
        'name'      => 'ASC',
    ];

    protected $fillable = [
        'name',
        'logo_id',
        'show_home',
        'priority',
    ];

    protected $attributes = [
        'show_home' => false,
    ];

    protected static $rules = [
        'name'      => [ 'required', 'min:2' ],
        'logo_id'   => [ 'sometimes', 'nullable' ],
        'show_home' => [ 'required', 'boolean' ],
        'priority'  => [ 'sometimes', 'nullable', 'numeric', 'min:1' ],
    ];

}
