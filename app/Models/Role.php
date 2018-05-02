<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{
    protected $collection = 'Role';
    protected $connection = 'mongodb';
}
