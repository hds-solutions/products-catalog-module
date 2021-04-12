<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

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
        'name'      => [ 'required', 'min:4' ],
        'line_id'   => [ 'required' ],
    ];

}
