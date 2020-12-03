<?php

namespace Tests\Common\Readers;

use App\Common\Adapters\FileSystemInterface;
use App\Common\Exceptions\FileException;
use App\Common\Readers\FileReader;
use App\Common\ValueObjects\AbstractFile;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FileReaderTest extends TestCase
{
    /**
     * @var MockObject|AbstractFile
     */
    private MockObject $file;

    /**
     * @var MockObject|FileSystemInterface
     */
    private MockObject $fileSystemAdapter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->file = $this->getMockBuilder(AbstractFile::class)->disableOriginalConstructor()->getMock();
        $this->file
            ->expects($this->any())
            ->method('getFilePath')
            ->willReturn('file');
        $this->fileSystemAdapter = $this->getMockBuilder(FileSystemInterface::class)->getMock();
    }

    public function testErrorIfFileNotExists(): void
    {
        $this->fileSystemAdapter
            ->expects($this->once())
            ->method('fileExists')
            ->willReturn(false);

        $this->fileSystemAdapter
            ->expects($this->never())
            ->method('getFileContent');

        $this->expectException(FileException::class);

        (new FileReader($this->file, $this->fileSystemAdapter))->read();
    }

    public function testErrorOnGetFileContentFailure(): void
    {
        $this->fileSystemAdapter
            ->expects($this->once())
            ->method('fileExists')
            ->willReturn(true);

        $this->fileSystemAdapter
            ->expects($this->once())
            ->method('getFileContent')
            ->willReturn(false);

        $this->expectException(FileException::class);

        (new FileReader($this->file, $this->fileSystemAdapter))->read();
    }

    public function testReturnContent(): void
    {
        $this->fileSystemAdapter
            ->expects($this->once())
            ->method('fileExists')
            ->willReturn(true);

        $this->fileSystemAdapter
            ->expects($this->once())
            ->method('getFileContent')
            ->willReturn('Lorem ipsum');

        $fileContent = (new FileReader($this->file, $this->fileSystemAdapter))->read();

        $this->assertEquals($fileContent, 'Lorem ipsum');
    }
}