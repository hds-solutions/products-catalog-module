<?php

namespace HDSSolutions\Laravel\Models;

class OptionValue extends X_OptionValue {

    public function option() {
        return $this->belongsTo(Option::class);
    }

}
