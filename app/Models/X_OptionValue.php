<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_OptionValue extends Base\Model {
    use BelongsToCompany;

    protected $fillable = [
        'option_id',
        'value',
        'extra',
    ];

}
