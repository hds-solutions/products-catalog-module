<?php

namespace hDSSolutions\Finpar\Models\Policies;

use HDSSolutions\Finpar\Models\Tag as Resource;
use HDSSolutions\Finpar\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->can('tags.crud.index');
    }

    public function view(User $user, Resource $resource) {
        return $user->can('tags.crud.show');
    }

    public function create(User $user) {
        return $user->can('tags.crud.create');
    }

    public function update(User $user, Resource $resource) {
        return $user->can('tags.crud.update');
    }

    public function delete(User $user, Resource $resource) {
        return $user->can('tags.crud.destroy');
    }

    public function restore(User $user, Resource $resource) {
        return $user->can('tags.crud.destroy');
    }

    public function forceDelete(User $user, Resource $resource) {
        return $user->can('tags.crud.destroy');
    }
}
