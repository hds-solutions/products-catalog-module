<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_Gama extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
        'line_id',
    ];

    protected static $rules = [
        'name'      => [ 'required', 'min:1' ],
        'line_id'   => [ 'required' ],
    ];

}
