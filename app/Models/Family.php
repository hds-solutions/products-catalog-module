<?php

namespace HDSSolutions\Laravel\Models;

class Family extends X_Family {

    public function subFamilies() {
        return $this->hasMany(SubFamily::class);
    }

    public function options() {
        return $this->belongsToMany(Option::class)
            ->using(FamilyOption::class)
            ->withTimestamps();
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

}
