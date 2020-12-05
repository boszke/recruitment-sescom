<?php

declare(strict_types=1);

namespace App\Common\Readers;

use App\Common\Adapters\FileSystemInterface;
use App\Common\Exceptions\FileException;
use App\Common\ValueObjects\AbstractFile;

class FileReader implements ReaderInterface
{
    private AbstractFile $file;

    private FileSystemInterface $filesystem;

    public function __construct(AbstractFile $file, FileSystemInterface $filesystem)
    {
        $this->file = $file;
        $this->filesystem = $filesystem;
    }

    public function read(): string
    {
        if (!$this->filesystem->fileExists($this->file->getFilePath())) {
            throw new FileException(sprintf('File not found: %s', $this->file->getFilePath()));
        }

        $fileContent = $this->filesystem->getFileContent($this->file->getFilePath());

        if (false === $fileContent) {
            throw new FileException(sprintf('File reading error: %s', $this->file->getFilePath()));
        }

        return $fileContent;
    }
}