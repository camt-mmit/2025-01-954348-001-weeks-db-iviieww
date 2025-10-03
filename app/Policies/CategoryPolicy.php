<?php

namespace App\Policies;

use App\Models\category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    function list(): bool
    {
        return true;
    }

    function view(): bool
    {
        return $this->list();
    }

    function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    function update(User $user): bool
    {
        return $this->create($user);
    }

    function delete(User $user, category $category): bool
    {
        $category->loadCount('products');
        return $this->update($user) && ($category->products_count === 0);
    }
}
