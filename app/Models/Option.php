<?php

namespace HDSSolutions\Laravel\Models;

class Option extends X_Option {

    public function values() {
        return $this->hasMany(OptionValue::class);
    }

}
