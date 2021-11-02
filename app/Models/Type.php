<?php

namespace HDSSolutions\Laravel\Models;

use Illuminate\Database\Eloquent\Builder;

class Type extends X_Type {

    public function options() {
        return $this->belongsToMany(Option::class)
            ->using(TypeOption::class)
            ->withTimestamps();
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function scopeSold(Builder $query, bool $sold = true) {
        return $query->where('is_sold', $sold);
    }

    public function scopeIsSold(Builder $query, bool $sold = true) {
        return $this->scopeSold($query, $sold);
    }

    public function scopeHasStock(Builder $query, bool $stock = true) {
        return $query->where('has_stock', $stock);
    }

}
