<?php

namespace HDSSolutions\Finpar\Models;

class Offer extends X_Offer {

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function variant() {
        return $this->belongsTo(Variant::class);
    }

}
