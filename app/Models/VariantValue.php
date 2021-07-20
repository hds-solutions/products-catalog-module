<?php

namespace HDSSolutions\Laravel\Models;

class VariantValue extends X_VariantValue {

    public function option() {
        return $this->belongsTo(Option::class);
    }

    public function optionValue() {
        return $this->belongsTo(OptionValue::class);
    }

    public function variant() {
        return $this->belongsTo(Variant::class);
    }

}
