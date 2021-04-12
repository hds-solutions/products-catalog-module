<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Traits\BelongsToCompany;

abstract class X_ProductTag extends Base\Pivot {
    use BelongsToCompany;

}
