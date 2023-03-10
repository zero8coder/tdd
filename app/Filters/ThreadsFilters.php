<?php

namespace App\Filters;

use App\Models\User;

class ThreadsFilters extends Filters
{
    protected $filters = ['by'];

    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrfail();
        return $this->builder->where('user_id', $user->id);
    }
}
