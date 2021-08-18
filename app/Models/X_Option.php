<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_Option extends Base\Model {
    use BelongsToCompany;

    const VALUE_TYPE_Text       = 'text';
    const VALUE_TYPE_Boolean    = 'boolean';
    const VALUE_TYPE_Choice     = 'choice';
    const VALUE_TYPE_Color      = 'color';
    const VALUE_TYPE_Image      = 'image';
    const VALUE_TYPES = [
        self::VALUE_TYPE_Text       => 'products-catalog::option.value_type.text',
        self::VALUE_TYPE_Boolean    => 'products-catalog::option.value_type.boolean',
        self::VALUE_TYPE_Choice     => 'products-catalog::option.value_type.choice',
        self::VALUE_TYPE_Color      => 'products-catalog::option.value_type.color',
        self::VALUE_TYPE_Image      => 'products-catalog::option.value_type.image',
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
