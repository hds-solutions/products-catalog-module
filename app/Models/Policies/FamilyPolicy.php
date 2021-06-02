<?php

namespace hDSSolutions\Finpar\Models\Policies;

use HDSSolutions\Finpar\Models\Family as Resource;
use HDSSolutions\Finpar\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FamilyPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('families.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('families.crud.show');
    }

    public function create(User $user) {
        return $user->can('families.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('families.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('families.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('families.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('families.crud.destroy');
    }
}
