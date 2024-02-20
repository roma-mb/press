<?php

namespace RomaMb\Press\Drivers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RomaMb\Press\Exceptions\FileDriverDirectoryNotFoundException;
use RomaMb\Press\PressFileParser;
use Symfony\Component\Finder\SplFileInfo;

class FileDriver extends Driver
{
    public function fetchPosts(): array
    {
        $files = File::files($this->config['path']);

        foreach ($files as $file) {
            $this->parse($file);
        }

        return $this->posts;
    }

    /** @throws \Throwable */
    protected function validateSource(): bool
    {
        $notExistFile = !File::exists($this->config['path'] ?? '');

        if ($notExistFile) {
            throw new FileDriverDirectoryNotFoundException(
                "Directory at {$this->config['path']} does not exist, check the directory in the config file"
            );
        }

        return true;
    }

    protected function parse(SplFileInfo $file): void
    {
        $parsedFile = (new PressFileParser($file->getPathname()))
            ->splitFile()
            ->explodeData()
            ->processFields()
            ->getData();

        $this->posts[] = [
            'identifier' =>  Str::slug($file->getFilename()),
            ...$parsedFile,
        ];
    }
}
