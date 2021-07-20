<?php

namespace hDSSolutions\Laravel\Models\Policies;

use HDSSolutions\Laravel\Models\Variant as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VariantPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('variants.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('variants.crud.show');
    }

    public function create(User $user) {
        return $user->can('variants.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('variants.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('variants.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('variants.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('variants.crud.destroy');
    }
}
