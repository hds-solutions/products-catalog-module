<?php

namespace HDSSolutions\Laravel\Models;

use HDSSolutions\Laravel\Models\Brand;

class Model extends X_Model {

    public function brand() {
        return $this->belongsTo(Brand::class);
    }
}
