<?php

namespace RomaMb\Press\Fields;

use Illuminate\Support\Carbon;

class Date extends FieldContract
{
    public static function process(array $attributes): array
    {
        $date = $attributes['date'] ?? '';

        return [
            'date' => Carbon::parse($date),
            'parse_at' => Carbon::now(),
        ];
    }
}
