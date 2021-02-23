<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;
use HDSSolutions\Finpar\Models\File;
use HDSSolutions\Finpar\Traits\BelongsToCompany;

class X_Brand extends Model {
    use BelongsToCompany;

    protected $orderBy = [
        'priority'  => 'DESC',
        'name'      => 'ASC',
    ];

    protected $fillable = [
        'name',
        'logo_id',
        'show_home',
        'priority',
    ];

    protected $attributes = [
        'show_home' => false,
    ];

    protected static $createRules = [
        'name'      => [ 'required', 'min:2' ],
        'logo_id'   => [ 'sometimes', 'nullable' ],
        'show_home' => [ 'required', 'boolean' ],
        'priority'  => [ 'sometimes', 'nullable', 'numeric', 'min:1' ],
    ];

    protected static $updateRules = [
        'name'      => [ 'required', 'min:2' ],
        'logo_id'   => [ 'sometimes', 'nullable' ],
        'show_home' => [ 'required', 'boolean' ],
        'priority'  => [ 'sometimes', 'nullable', 'numeric', 'min:1' ],
    ];

}
