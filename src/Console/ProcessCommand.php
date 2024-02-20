<?php

namespace RomaMb\Press\Console;

use Illuminate\Console\Command;
use RomaMb\Press\Facades\Press;
use RomaMb\Press\Repositories\PostRepository;

class ProcessCommand extends Command
{
    protected $signature = 'press:process';

    protected $description = 'Update blog posts.';

    public function handle(PostRepository $postRepository): void
    {
        if (Press::configNotPublished()) {
            $this->warn('Please publish the config file by running  \'php artisan vendor:publish --tag=press-config\'');

            return;
        }

        $this->savePosts($postRepository);
    }

    private function savePosts(PostRepository $postRepository): void
    {
        try {
            $posts = Press::driver()->fetchPosts();
            $this->line('PROCESS...');

            foreach ($posts as $post) {
                $model = $postRepository->save($post);
                $this->info('Post, ' . $model?->title . ': Saved...');
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
