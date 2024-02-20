<?php

namespace RomaMb\Press;

class Press
{
    private array $fields = [];

    public function configNotPublished(): bool
    {
        return config('press') === null;
    }

    public function driver()
    {
        $driver = ucfirst(config('press.driver'));
        $class = 'RomaMb\Press\Drivers\\' . $driver . 'Driver';

        return new $class();
    }

    public function path(): ?string
    {
        return config('press.path', 'blog');
    }

    public function mergeFields(array $fields): void
    {
        $this->fields = [...$this->fields, ...$fields];
    }

    public function availableFields(): array
    {
        return $this->fields;
    }
}
