<?php

namespace RomaMb\Press\Fields;

abstract class FieldContract
{
    public static function process(array $attributes): array
    {
        $key = key($attributes);

        return [
            $key => $attributes[$key] ?? '',
        ];
    }
}
