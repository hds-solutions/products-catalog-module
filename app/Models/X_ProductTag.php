<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_ProductTag extends Base\Pivot {
    use BelongsToCompany;

}
