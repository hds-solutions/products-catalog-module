<?php

namespace HDSSolutions\Finpar\Models;

use Illuminate\Database\Eloquent\Collection;

class ProductPrice extends X_ProductPrice {

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

}
