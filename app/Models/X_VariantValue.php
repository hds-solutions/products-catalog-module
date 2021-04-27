<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Builder;

abstract class X_VariantValue extends Base\Pivot {
    use BelongsToCompany;

    // protected $foreignKey = 'variant_id';
    protected $relatedKey = 'option_id';

    protected $fillable = [
        'variant_id',
        'option_id',
        'option_value_id',
        'value',
    ];

    protected function setKeysForSaveQuery($query) {
        // set composite key
        $query->where('variant_id', $this->attributes['variant_id']);
        $query->where('option_id',  $this->attributes['option_id']);
        //
        return $query;
    }

}
