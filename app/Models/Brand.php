<?php

namespace HDSSolutions\Finpar\Models;

use Illuminate\Database\Eloquent\Builder;

class Brand extends X_Brand {

    public function models() {
        return $this->hasMany(Model::class);
    }

    public function logo() {
        return $this->belongsTo(File::class);
    }

    public function scopeShowHome(Builder $query) {
        return $query->where('show_home', true);
    }

}
