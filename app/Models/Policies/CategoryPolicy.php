<?php

namespace hDSSolutions\Laravel\Models\Policies;

use HDSSolutions\Laravel\Models\Category as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('categories.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('categories.crud.show');
    }

    public function create(User $user) {
        return $user->can('categories.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('categories.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('categories.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('categories.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('categories.crud.destroy');
    }
}
