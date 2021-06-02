<?php

namespace hDSSolutions\Finpar\Models\Policies;

use HDSSolutions\Finpar\Models\Type as Resource;
use HDSSolutions\Finpar\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypePolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('types.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('types.crud.show');
    }

    public function create(User $user) {
        return $user->can('types.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('types.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('types.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('types.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('types.crud.destroy');
    }
}
