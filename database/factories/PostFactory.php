<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RomaMb\Press\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * @inheritDoc
     *
     * @throws \JsonException
     */
    public function definition(): array
    {
        return [
            'identifier' => Str::random(),
            'slug' => $this->faker->slug,
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'extra' => json_encode(['test' => 'value'], JSON_THROW_ON_ERROR),
        ];
    }

    /**
     * @return Collection
     */
    public function getAfterCreating(): Collection
    {
        return $this->afterCreating;
    }
}
