<?php

namespace HDSSolutions\Finpar\Models;

class VariantValue extends X_VariantValue {

    public function option() {
        return $this->belongsTo(Option::class);
    }

    public function option_value() {
        return $this->belongsTo(OptionValue::class);
    }

    public function variant() {
        return $this->belongsTo(Variant::class);
    }

}
