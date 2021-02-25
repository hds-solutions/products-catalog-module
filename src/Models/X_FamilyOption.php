<?php

namespace HDSSolutions\Finpar\Models;

use App\Models\Base\Pivot;
use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_FamilyOption extends Pivot {
    use BelongsToCompany;

}
