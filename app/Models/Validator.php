<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Validator extends Model
{
    protected $collection = 'Validator';
    protected $connection = 'mongodb';
}

?>