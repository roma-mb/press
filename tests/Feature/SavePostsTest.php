<?php

namespace RomaMb\Press\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use RomaMb\Press\Models\Post;
use RomaMb\Press\Tests\TestCase;

class SavePostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_post_can_be_created_with_the_factory(): void
    {
        $post = Post::factory()->create();

        $this->assertCount(1, Post::all());
        $this->assertInstanceOf(Post::class, $post);
    }
}
