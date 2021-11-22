<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_SubFamily extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
        'family_id',
    ];

    protected static $rules = [
        'name'      => [ 'required', 'min:1' ],
        'family_id' => [ 'required' ],
    ];

}
