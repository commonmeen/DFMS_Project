<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Step extends Model
{
    protected $collection = 'Step';
    protected $connection = 'mongodb';
}
