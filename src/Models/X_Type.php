<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;
use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_Type extends Model {
    use BelongsToCompany;

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
        'sold',
    ];

    protected static $createRules = [
        'name'  => [ 'required', 'min:4' ],
        'sold'  => [ 'required', 'boolean' ],
    ];

    protected static $updateRules = [
        'name'  => [ 'required', 'min:4' ],
        'sold'  => [ 'required', 'boolean' ],
    ];

}
