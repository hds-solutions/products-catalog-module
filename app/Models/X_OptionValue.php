<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_OptionValue extends Base\Model {
    use BelongsToCompany;

    protected $fillable = [
        'option_id',
        'value',
        'extra',
    ];

}
