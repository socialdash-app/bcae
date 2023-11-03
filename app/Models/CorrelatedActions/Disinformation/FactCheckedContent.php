<?php

namespace App\Models\CorrelatedActions\Disinformation;

use App\Models\BaseModel;

class FactCheckedContent extends BaseModel
{
    public function article(): \Illuminate\Database\Eloquent\Relations\BelongsTo|\MongoDB\Laravel\Relations\BelongsTo
    {
        return $this->belongsTo(FactCheckedArticle::class, 'fact_checked_article_id', 'id');
    }
}
