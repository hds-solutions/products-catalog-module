<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model as Base_Model;
use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_Model extends Base_Model {
    use BelongsToCompany;

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
        'brand_id',
    ];

    protected static $createRules = [
        'name'      => [ 'required', 'min:2' ],
        'brand_id'  => [ 'required' ],
    ];

    protected static $updateRules = [
        'name'      => [ 'required', 'min:2' ],
        'brand_id'  => [ 'required' ],
    ];
}
