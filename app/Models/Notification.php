<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Notification extends Model
{
    protected $collection = 'Notification';
    protected $connection = 'mongodb';
}
