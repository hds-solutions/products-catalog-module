<?php

namespace HDSSolutions\Laravel\Models;

use Illuminate\Database\Eloquent\Builder;

class Brand extends X_Brand {

    public function logo() {
        return $this->belongsTo(File::class);
    }

    public function models() {
        return $this->hasMany(Model::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function scopeShowHome(Builder $query) {
        return $query->where('show_home', true);
    }

}
