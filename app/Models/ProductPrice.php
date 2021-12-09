<?php

namespace HDSSolutions\Laravel\Models;

use Illuminate\Database\Eloquent\Collection;

class ProductPrice extends X_ProductPrice {

    public function priceListVersion() {
        return $this->belongsTo(PriceListVersion::class)
            ->withTrashed();
    }

    public function product() {
        return $this->belongsTo(Product::class)
            ->withTrashed();
    }

    public function variant() {
        return $this->belongsTo(Variant::class)
            ->withTrashed();
    }

}
