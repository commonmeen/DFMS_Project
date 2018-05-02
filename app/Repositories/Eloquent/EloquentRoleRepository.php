<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentRoleRepository extends AbstractRepository implements RoleRepository
{
    public function entity()
    {
        return Role::class;
    }

    public static function getAllRole()
    {
        $data = Role::all();
        return json_decode($data);
    }
}
