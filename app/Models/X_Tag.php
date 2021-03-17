<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;
use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_Tag extends Model {
    use BelongsToCompany;

    protected $orderBy = [
        'name'      => 'ASC',
    ];

    protected $fillable = [
        'name',
    ];

    protected static $createRules = [
        'name'      => [ 'required', 'min:4' ],
    ];

    protected static $updateRules = [
        'name'      => [ 'required', 'min:4' ],
    ];

}
