<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Template extends Model
{
    protected $collection = 'Template';
    protected $connection = 'mongodb';
}

?>
