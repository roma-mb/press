<?php

namespace RomaMb\Press\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }

    /** @throws \JsonException */
    public function getExtraAttribute(string $value): mixed
    {
        return json_decode($value, false, 512, JSON_THROW_ON_ERROR);
    }
}
