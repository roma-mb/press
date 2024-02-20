<?php

namespace RomaMb\Press\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RomaMb\Press\Models\Post;

class PostRepository
{
    /** @throws \JsonException */
    public function save(array $post): Post
    {
        $title = $post['title'] ?? '';

        return Post::updateOrCreate([
            'identifier' => $post['identifier'] ?? '',
        ], [
            'slug' => Str::slug($title),
            'title' => $title,
            'body' => $post['body'] ?? '',
            'extra' => $this->extras($post),
        ]);
    }

    /** @throws \JsonException */
    private function extras(array $post): array
    {
        $extra = $post['extra'] ?? '[]';
        $extrasDecoded = json_decode($extra, true, 512, JSON_THROW_ON_ERROR);
        $except = Arr::except($post, ['identifier', 'slug', 'title', 'body', 'extra']);

        return [
            ...$except,
            ...$extrasDecoded,
        ];
    }
}
