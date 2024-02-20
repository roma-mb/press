<?php

namespace RomaMb\Press;

class MarkdownParser
{
    public static function parser(string $text): string
    {
        return \Parsedown::instance()->text($text);
    }
}
