<?php

namespace Tests\Reports\Readers;

use App\Reports\Adapters\FileSystemInterface;
use App\Reports\Exceptions\FileException;
use App\Reports\Readers\FileReader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FileReaderTest extends TestCase
{
    /**
     * @var MockObject|FileSystemInterface
     */
    private MockObject $fileSystemAdapter;

    protected function setUp(): void
    {
        parent::setUp();

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

        (new FileReader('path', $this->fileSystemAdapter))->read();
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

        (new FileReader('path', $this->fileSystemAdapter))->read();
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

        $fileContent = (new FileReader('path', $this->fileSystemAdapter))->read();

        $this->assertEquals($fileContent, 'Lorem ipsum');
    }
}