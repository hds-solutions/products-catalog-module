<?php

namespace HDSSolutions\Finpar\Models;

class OptionValue extends X_OptionValue {

    public function option() {
        return $this->belongsTo(Option::class);
    }

}
