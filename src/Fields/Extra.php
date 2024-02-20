<?php

namespace RomaMb\Press\Fields;

class Extra extends FieldContract
{
    /**
     * @throws \JsonException
     */
    public static function process($attributes): array
    {
        $type = key($attributes);
        $extra = $attributes['data']['extra'] ?? '[]';
        $extraParsed = json_decode($extra, true, 512, JSON_THROW_ON_ERROR);
        $extraParsed[$type] = $attributes[$type] ?? '';

        return [
            'extra' => json_encode($extraParsed, JSON_THROW_ON_ERROR),
        ];
    }
}
