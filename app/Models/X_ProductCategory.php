<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Traits\BelongsToCompany;

abstract class X_ProductCategory extends Base\Pivot {
    use BelongsToCompany;

}
