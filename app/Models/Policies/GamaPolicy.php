<?php

namespace hDSSolutions\Finpar\Models\Policies;

use HDSSolutions\Finpar\Models\Gama as Resource;
use HDSSolutions\Finpar\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamaPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('gamas.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('gamas.crud.show');
    }

    public function create(User $user) {
        return $user->can('gamas.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('gamas.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('gamas.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('gamas.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('gamas.crud.destroy');
    }
}
