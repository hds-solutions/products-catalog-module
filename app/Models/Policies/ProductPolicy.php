<?php

namespace hDSSolutions\Laravel\Models\Policies;

use HDSSolutions\Laravel\Models\Product as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('products.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('products.crud.show');
    }

    public function create(User $user) {
        return $user->can('products.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('products.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('products.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('products.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('products.crud.destroy');
    }
}
