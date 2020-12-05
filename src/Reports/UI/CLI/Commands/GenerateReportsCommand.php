<?php

declare(strict_types=1);

namespace App\Reports\UI\CLI\Commands;

use App\Common\Adapters\FileSystemAdapter;
use App\Common\Exceptions\DecoderException;
use App\Common\Exceptions\FileException;
use App\Common\Readers\FileReader;
use App\Common\Services\FileReaderDecoderService;
use App\Common\ValueObjects\JsonFile;
use App\Reports\Dictionaries\AbstractInformationTypesDictionary;
use App\Reports\DTO\InformationCollection;
use App\Reports\Mappers\InformationMapper;
use App\Reports\Resolvers\InformationTypeResolver;
use App\Reports\Resolvers\UniqueDescriptionInformationTypeResolverDecorator;
use App\Reports\Services\InformationService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateReportsCommand extends Command
{
    private const SOURCE_PATH_ARGUMENT_NAME = 'filepath';

    /**
     * @var string
     */
    protected static $defaultName = 'reports:generate';

    protected function configure(): void
    {
        $this
            ->setDescription('Command for generate reports from JSON file')
            ->addArgument(self::SOURCE_PATH_ARGUMENT_NAME, InputArgument::REQUIRED, 'Source file path');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sourcePath = $input->getArgument(self::SOURCE_PATH_ARGUMENT_NAME);

        $file = new JsonFile($sourcePath);
        $fileReader = new FileReader($file, new FileSystemAdapter());
        $fileDecoderService = new FileReaderDecoderService($file, $fileReader);

        $collection = new InformationCollection();
        $mapper = new InformationMapper();
        $resolver = new UniqueDescriptionInformationTypeResolverDecorator(new InformationTypeResolver(), $collection);
        $collectionService = new InformationService($fileDecoderService, $mapper, $collection, $resolver);
        try {
            $collection = $collectionService->buildTypeCollection();
            $collectionReview = $collection->filterByType(AbstractInformationTypesDictionary::INFORMATION_TYPE_REVIEW);
            $collectionAccident = $collection->filterByType(AbstractInformationTypesDictionary::INFORMATION_TYPE_ACCIDENT);
            $collectionUnprocessed = $collection->filterByType(AbstractInformationTypesDictionary::INFORMATION_TYPE_UNPROCESSED);


            //TODO do zmiany na logowanie
            echo 'Przetworzone wiadomości: ';
            echo count($collection->getCollection());
            echo PHP_EOL;

            echo 'Liczba utworzonych przeglądów: ';
            echo count($collectionReview);
            echo PHP_EOL;

            echo 'Liczba utworzonych awarii: ';
            echo count($collectionAccident);
            echo PHP_EOL;

            foreach ($collectionUnprocessed as $unprocessed) {
                echo sprintf('Nie przetworzono zadania: %d. Powód: %s', $unprocessed->getNumber(), $unprocessed->getReason());
                echo PHP_EOL;
            }

            //TODO zapis do plików json
            //TODO logowanie istotnych momentów

        } catch (FileException | DecoderException | Exception $e) {
            echo 'error: ' . $e->getMessage();

            return Command::FAILURE;
        }


        return Command::SUCCESS;
    }
}