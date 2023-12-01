<?php

namespace App\Models\ProminentEvents;

use App\Models\BaseModel;

class ElectionIncident extends BaseModel
{
    protected $fillable = ['description_mm', 'description_en', 'topic', 'url'];
}
