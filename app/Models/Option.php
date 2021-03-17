<?php

namespace HDSSolutions\Finpar\Models;

class Option extends X_Option {

    public function values() {
        return $this->hasMany(OptionValue::class);
    }

}
