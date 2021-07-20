<?php

namespace hDSSolutions\Laravel\Models\Policies;

use HDSSolutions\Laravel\Models\Model as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModelPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('models.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('models.crud.show');
    }

    public function create(User $user) {
        return $user->can('models.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('models.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('models.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('models.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('models.crud.destroy');
    }
}
