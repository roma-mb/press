<?php

namespace RomaMb\Press;

use Illuminate\Support\Facades\File;
use RomaMb\Press\Fields\Extra;

class PressFileParser
{
    protected string $file;

    protected array $rawData = [];

    protected array $data = [];

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function getRawData(): array
    {
        return $this->rawData;
    }

    public function getData(): array
    {
        return array_filter($this->data);
    }

    public function splitFile(): static
    {
        preg_match(
            '/^\-{3}(.*?)\-{3}(.*)/s',
            File::exists($this->file) ? File::get($this->file) : $this->file,
            $this->rawData
        );

        return $this;
    }

    public function explodeData(): static
    {
        $lines = explode("\n", trim($this->rawData[1]));

        foreach ($lines as $line) {
            preg_match('/(.*):\s?(.*)/', $line, $attribute);
            $this->data[$attribute[1]] = $attribute[2];
        }

        $this->data['body'] = trim($this->rawData[2]);

        return $this;
    }

    public function processFields(): static
    {
        foreach ($this->data as $key => $value) {
            $class = \RomaMb\Press\Facades\Press::availableFields()[ucfirst($key)] ?? '';

            if (!class_exists($class) && !method_exists($class, 'process')) {
                $class = Extra::class;
            }

            $field = $class::process([$key => $value, 'data' => $this->data]);
            $this->data = [...$this->data, ...$field];
        }

        return $this;
    }
}
