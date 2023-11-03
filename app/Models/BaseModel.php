<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class BaseModel extends Model
{
    protected $connection = 'mongodb';

    protected $hidden = ['_id', 'created_at', 'updated_at'];
    protected $guarded = [];
}
