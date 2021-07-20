<?php

namespace hDSSolutions\Laravel\Models\Policies;

use HDSSolutions\Laravel\Models\SubFamily as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubFamilyPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('sub_families.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('sub_families.crud.show');
    }

    public function create(User $user) {
        return $user->can('sub_families.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('sub_families.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('sub_families.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('sub_families.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('sub_families.crud.destroy');
    }
}
