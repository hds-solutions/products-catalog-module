<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_SubFamily extends Base\Model {
    use BelongsToCompany;

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
        'family_id',
    ];

    protected static $createRules = [
        'name'      => [ 'required', 'min:4' ],
        'family_id' => [ 'required' ],
    ];

    protected static $updateRules = [
        'name'      => [ 'required', 'min:4' ],
        'family_id' => [ 'required' ],
    ];

}
