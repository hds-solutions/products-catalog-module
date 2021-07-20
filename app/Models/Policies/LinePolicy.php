<?php

namespace hDSSolutions\Laravel\Models\Policies;

use HDSSolutions\Laravel\Models\Line as Resource;
use HDSSolutions\Laravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinePolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('lines.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('lines.crud.show');
    }

    public function create(User $user) {
        return $user->can('lines.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('lines.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('lines.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('lines.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('lines.crud.destroy');
    }
}
