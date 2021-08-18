<?php

namespace HDSSolutions\Laravel\Models;

class Gama extends X_Gama {

    public function line() {
        return $this->belongsTo(Line::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

}
