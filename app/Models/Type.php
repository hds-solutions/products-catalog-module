<?php

namespace HDSSolutions\Finpar\Models;

use Illuminate\Database\Eloquent\Builder;

class Type extends X_Type {

    public function options() {
        return $this->belongsToMany(Option::class)
            ->using(TypeOption::class)
            ->withTimestamps();
    }

    public function scopeIsSold(Builder $query, bool $sold = true) {
        return $query->where('is_sold', $sold);
    }

    public function scopeHasStock(Builder $query, bool $stock = true) {
        return $query->where('has_stock', $stock);
    }

}
