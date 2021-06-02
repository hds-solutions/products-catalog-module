<?php

namespace hDSSolutions\Finpar\Models\Policies;

use HDSSolutions\Finpar\Models\Option as Resource;
use HDSSolutions\Finpar\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OptionPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('options.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('options.crud.show');
    }

    public function create(User $user) {
        return $user->can('options.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('options.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('options.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('options.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('options.crud.destroy');
    }
}
