<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Document extends Model
{
    protected $collection = 'Document';
    protected $connection = 'mongodb';
}
