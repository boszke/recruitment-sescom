<?php

declare(strict_types=1);

namespace App\Common\Adapters;

interface FileSystemInterface
{
    public function fileExists(string $fileName): bool;

    /**
     * @param string $fileName
     * @return false|string
     */
    public function getFileContent(string $fileName);

    /**
     * @param string $fileName
     * @param string $content
     * @return int|false
     */
    public function saveFileContent(string $fileName, string $content);

    public function createDirectory(string $pathName): bool;

    public function getDirectoryPathFromFilePath(string $fileName): string;
}