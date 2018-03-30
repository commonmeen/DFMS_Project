<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Flow extends Model
{
    protected $collection = 'Flow';
    protected $connection = 'mongodb';
}
