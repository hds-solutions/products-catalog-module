<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_ProductCategory extends Base\Pivot {
    use BelongsToCompany;

}
