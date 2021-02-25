<?php

namespace HDSSolutions\Finpar\Models;

class Gama extends X_Gama {

    public function line() {
        return $this->belongsTo(Line::class);
    }

}
