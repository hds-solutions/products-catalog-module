<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Model;
use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_Gama extends Model {
    use BelongsToCompany;

    protected $orderBy = [
        'name'  => 'ASC',
    ];

    protected $fillable = [
        'name',
        'line_id',
    ];

    protected static $createRules = [
        'name'      => [ 'required', 'min:4' ],
        'line_id'   => [ 'required' ],
    ];

    protected static $updateRules = [
        'name'      => [ 'required', 'min:4' ],
        'line_id'   => [ 'required' ],
    ];

}
