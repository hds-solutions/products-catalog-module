<?php

namespace HDSSolutions\Laravel\Models;

class Tag extends X_Tag {

    public function products() {
        return $this->hasMany(Product::class);
    }

}
