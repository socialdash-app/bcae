<?php

namespace App\Services;

use App\Models\CorrelatedActions\Disinformation\FactCheckedContent;
use App\Models\CorrelatedActions\Protest;

class CorrelatedActionsService
{
    public static function getProtestData(): \Illuminate\Database\Eloquent\Collection
    {
        return Protest::all();
    }

    public static function getDisinformationData(): array
    {
        // get contents
        $contents = FactCheckedContent::with('article')->get();
        // filter valid username or id
        $validPropagandists = [];
        $unrecognizableContents = [];
        foreach ($contents as $content) {
            $uniqueValue = $content->id ?? $content->username;
            if (!$uniqueValue) {
                $unrecognizableContents[] = $content->toArray();
                continue;
            }
            if (empty($validPropagandists[$uniqueValue])) {
                $validPropagandists[$uniqueValue] = [];
            }
            $validPropagandists[$uniqueValue][] = $content->toArray();
        }
        return [
            'validPropagandists' => $validPropagandists,
            'unrecognizableContents' => $unrecognizableContents
        ];
    }
}
