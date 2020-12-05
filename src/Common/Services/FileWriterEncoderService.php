<?php

declare(strict_types=1);

namespace App\Common\Services;

use App\Common\Encoders\EncoderFactoryInterface;
use App\Common\Writers\WriterInterface;

class FileWriterEncoderService implements FileWriterEncoderServiceInterface
{
    /**
     * @var EncoderFactoryInterface
     */
    private EncoderFactoryInterface $encoder;

    /**
     * @var WriterInterface
     */
    private WriterInterface $writer;

    public function __construct(EncoderFactoryInterface $encoder, WriterInterface $writer)
    {
        $this->encoder = $encoder;
        $this->writer = $writer;
    }

    /**
     * @inheritDoc
     */
    public function run(array $data): void
    {
        $this->writer->write($this->encoder->getEncoder()->encode($data));
    }
}