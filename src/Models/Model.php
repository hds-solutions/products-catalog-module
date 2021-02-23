<?php

namespace HDSSolutions\Finpar\Models;

use HDSSolutions\Finpar\Models\Brand;

class Model extends X_Model {

    public function brand() {
        return $this->belongsTo(Brand::class);
    }
}
