<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;
use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_OptionValue extends Model {
    use BelongsToCompany;

    protected $fillable = [
        'option_id',
        'value',
        'extra',
    ];

}
