<?php

namespace RomaMb\Press\Fields;

use RomaMb\Press\MarkdownParser;

class Body extends FieldContract
{
    public static function process(array $attributes): array
    {
        return [
            'body' => MarkdownParser::parser($attributes['body'] ?? ''),
        ];
    }
}
