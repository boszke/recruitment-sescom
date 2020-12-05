<?php


namespace App\Common\Writers;

use App\Common\Adapters\FileSystemInterface;
use App\Common\Exceptions\FileException;
use App\Common\ValueObjects\AbstractFile;

class FileWriter implements WriterInterface
{
    private AbstractFile $file;

    private FileSystemInterface $filesystem;

    public function __construct(AbstractFile $file, FileSystemInterface $filesystem)
    {
        $this->file = $file;
        $this->filesystem = $filesystem;
    }

    /**
     * @inheritDoc
     */
    public function write($data): void
    {
        if (!is_string($data)) {
            throw new FileException('Data is not valid');
        }

        $dirPath = $this->filesystem->getDirectoryPathFromFilePath($this->file->getFilePath());
        if (!$this->filesystem->fileExists($dirPath) && !$this->filesystem->createDirectory($dirPath)) {
            throw new FileException('Directory creation failed');
        }

        if ($this->filesystem->saveFileContent($this->file->getFilePath(), $data) === false) {
            throw new FileException('Failed to save the file');
        }
    }
}