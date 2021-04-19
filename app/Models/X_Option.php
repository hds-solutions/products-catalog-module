<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_Option extends Base\Model {
    use BelongsToCompany;

    const VALUE_TYPES = [
        'text'  => 'products-catalog::option.value_type.text',
        'color' => 'products-catalog::option.value_type.color',
        'image' => 'products-catalog::option.value_type.image',
    ];

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
        'label',
        'value_type',
        'show',
    ];

}
