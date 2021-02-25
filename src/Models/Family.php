<?php

namespace HDSSolutions\Finpar\Models;

class Family extends X_Family {

    public function sub_families() {
        return $this->hasMany(SubFamily::class);
    }

    public function options() {
        return $this->belongsToMany(Option::class)
            ->using(FamilyOption::class)
            ->withTimestamps();
    }

}
