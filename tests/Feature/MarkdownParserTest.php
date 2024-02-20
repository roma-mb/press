<?php

namespace RomaMb\Press\Tests\Feature;

use RomaMb\Press\MarkdownParser;
use RomaMb\Press\Tests\TestCase;

class MarkdownParserTest extends TestCase
{
    public function test_markdown_parser(): void
    {
        $parsed = MarkdownParser::parser('# Hello World!');
        $this->assertEquals('<h1>Hello World!</h1>', $parsed);
    }
}
