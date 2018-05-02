<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Position extends Model
{
    protected $collection = 'Position';
    protected $connection = 'mongodb';
}
