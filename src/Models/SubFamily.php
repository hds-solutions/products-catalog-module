<?php

namespace HDSSolutions\Finpar\Models;

class SubFamily extends X_SubFamily {

    public function family() {
        return $this->belongsTo(Family::class);
    }

}
