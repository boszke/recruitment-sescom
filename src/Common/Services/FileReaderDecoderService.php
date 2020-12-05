<?php

declare(strict_types=1);

namespace App\Common\Services;

use App\Common\Decoders\DecoderFactoryInterface;
use App\Common\Exceptions\DecoderException;
use App\Common\Exceptions\FileException;
use App\Common\Readers\ReaderInterface;
use Generator;

class FileReaderDecoderService implements FileReaderDecoderServiceInterface
{
    /**
     * @var DecoderFactoryInterface
     */
    private DecoderFactoryInterface $decoder;

    /**
     * @var ReaderInterface
     */
    private ReaderInterface $reader;

    public function __construct(DecoderFactoryInterface $decoder, ReaderInterface $reader)
    {
        $this->decoder = $decoder;
        $this->reader = $reader;
    }

    /**
     * @return Generator
     * @throws DecoderException
     * @throws FileException
     */
    public function run(): Generator
    {
        $data = $this->decoder->getDecoder()->decode($this->reader->read());
        foreach ($data as $row) {
            yield $row;
        }
    }
}