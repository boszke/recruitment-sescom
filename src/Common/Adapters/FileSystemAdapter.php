<?php

declare(strict_types=1);

namespace App\Common\Adapters;

use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;

class FileSystemAdapter extends Filesystem implements FileSystemInterface
{
    public function fileExists(string $fileName): bool
    {
        return $this->exists($fileName);
    }

    /**
     * @param string $fileName
     * @return false|string
     */
    public function getFileContent(string $fileName)
    {
        return file_get_contents($fileName);
    }

    /**
     * @param string $fileName
     * @param string $content
     * @return false|int
     */
    public function saveFileContent(string $fileName, string $content)
    {
        return file_put_contents($fileName, $content);
    }

    public function createDirectory(string $pathName): bool
    {
        try {
            $this->mkdir($pathName);
        } catch (RuntimeException $exception) {
            return false;
        }

        return true;
    }
}