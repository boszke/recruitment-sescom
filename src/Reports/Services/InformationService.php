<?php

declare(strict_types=1);

namespace App\Reports\Services;

use App\Common\Services\FileReaderDecoderServiceInterface;
use App\Reports\DTO\InformationCollection;
use App\Reports\Mappers\GeneratorMapperInterface;
use App\Reports\Resolvers\InformationResolverInterface;

class InformationService
{
    private FileReaderDecoderServiceInterface $fileReaderDecoderService;

    private InformationCollection $collection;

    private InformationResolverInterface $resolver;

    private GeneratorMapperInterface $mapper;

    /**
     * @param FileReaderDecoderServiceInterface $fileReaderDecoderService
     * @param GeneratorMapperInterface $mapper
     * @param InformationCollection $collection
     * @param InformationResolverInterface $resolver
     */
    public function __construct(
        FileReaderDecoderServiceInterface $fileReaderDecoderService,
        GeneratorMapperInterface $mapper,
        InformationCollection $collection,
        InformationResolverInterface $resolver
    )
    {
        $this->fileReaderDecoderService = $fileReaderDecoderService;
        $this->collection = $collection;
        $this->resolver = $resolver;
        $this->mapper = $mapper;
    }

    /**
     * @return InformationCollection
     * @throws \App\Common\Exceptions\DecoderException
     * @throws \App\Common\Exceptions\FileException
     * @throws \Exception
     */
    public function buildTypeCollection(): InformationCollection
    {
        $data = $this->mapper->map($this->fileReaderDecoderService->run());
        foreach ($data as $item) {
            $this->collection->add($this->resolver->resolve($item));
        }

        return $this->collection;
    }
}