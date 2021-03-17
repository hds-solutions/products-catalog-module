<?php

namespace HDSSolutions\Finpar\Models;

class Line extends X_Line {

    public function gamas() {
        return $this->hasMany(Gama::class);
    }

    public function options() {
        return $this->belongsToMany(Option::class)
            ->using(LineOption::class)
            ->withTimestamps();
    }

}
