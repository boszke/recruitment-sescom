<?php

declare(strict_types=1);

namespace App\Reports\Readers;

use App\Reports\Adapters\FileSystemInterface;
use App\Reports\Exceptions\FileException;

class FileReader implements ReaderInterface
{
    private string $filePath;

    private FileSystemInterface $filesystem;

    public function __construct(string $filePath, FileSystemInterface $filesystem)
    {
        $this->filePath = $filePath;
        $this->filesystem = $filesystem;
    }

    public function read(): string
    {
        if (!$this->filesystem->fileExists($this->filePath)) {
            throw new FileException(sprintf('File not found: %s', $this->filePath));
        }

        $fileContent = $this->filesystem->getFileContent($this->filePath);

        if (false === $fileContent) {
            throw new FileException(sprintf('File reading error: %s', $this->filePath));
        }

        return $fileContent;
    }
}