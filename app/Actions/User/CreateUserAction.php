<?php

namespace App\Actions\User;

use App\Enums\Role;
use App\Models\User;

class CreateUserAction
{
    /**
     * @param array $data
     * @return User
     */
    public function execute(array $data): User
    {
        return User::create($data);
    }
}
