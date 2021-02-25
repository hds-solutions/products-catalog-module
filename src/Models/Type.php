<?php

namespace HDSSolutions\Finpar\Models;

use Illuminate\Database\Eloquent\Builder;

class Type extends X_Type {

    public function options() {
        return $this->belongsToMany(Option::class)
            ->using(TypeOption::class)
            ->withTimestamps();
    }

    public function scopeSold(Builder $query, bool $sold = true) {
        return $query->where('sold', $sold);
    }
}
