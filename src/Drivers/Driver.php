<?php

namespace RomaMb\Press\Drivers;

abstract class Driver
{
    protected array $posts = [];

    protected ?array $config = [];

    public function __construct()
    {
        $this->setConfig();
        $this->validateSource();
    }

    protected function setConfig(): void
    {
        $this->config = config('press.' . config('press.driver'));
    }

    protected function validateSource(): bool
    {
        return true;
    }

    abstract public function fetchPosts();
}
