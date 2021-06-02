<?php

namespace hDSSolutions\Finpar\Models\Policies;

use HDSSolutions\Finpar\Models\Brand as Resource;
use HDSSolutions\Finpar\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('brands.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('brands.crud.show');
    }

    public function create(User $user) {
        return $user->can('brands.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('brands.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('brands.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('brands.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('brands.crud.destroy');
    }
}
