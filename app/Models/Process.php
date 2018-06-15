<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Process extends Model
{
    protected $collection = 'Process';
    protected $connection = 'mongodb';
}
