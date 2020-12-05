<?php

declare(strict_types=1);

namespace App\Reports\UI\CLI\Commands;

use App\Common\Adapters\FileSystemAdapter;
use App\Common\Exceptions\DecoderException;
use App\Common\Exceptions\EncoderException;
use App\Common\Exceptions\FileException;
use App\Common\Readers\FileReader;
use App\Common\Services\FileReaderDecoderService;
use App\Common\Services\FileWriterEncoderService;
use App\Common\ValueObjects\JsonFile;
use App\Common\Writers\FileWriter;
use App\Reports\Dictionaries\AbstractInformationTypesDictionary;
use App\Reports\DTO\InformationCollection;
use App\Reports\Mappers\InformationMapper;
use App\Reports\Resolvers\InformationTypeResolver;
use App\Reports\Resolvers\UniqueDescriptionInformationTypeResolverDecorator;
use App\Reports\Services\InformationService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
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
        $logger = new ConsoleLogger($output);
        $logger->info(sprintf("Command %s started", self::$defaultName));

        $sourcePath = $input->getArgument(self::SOURCE_PATH_ARGUMENT_NAME);
        if (!is_string($sourcePath)) {
            $logger->error('File path must be string');

            return Command::FAILURE;
        }

        $file = new JsonFile($sourcePath);
        $fileReader = new FileReader($file, new FileSystemAdapter());
        $fileDecoderService = new FileReaderDecoderService($file, $fileReader);

        $collection = new InformationCollection();
        $mapper = new InformationMapper();
        $resolver = new UniqueDescriptionInformationTypeResolverDecorator(new InformationTypeResolver(), $collection);
        $collectionService = new InformationService($fileDecoderService, $mapper, $collection, $resolver);
        try {
            $logger->info('Recognition of types of messages');
            $collection = $collectionService->buildTypeCollection();

            $logger->info('Create collections by message types');
            $collectionReview = $collection->createInstanceByType(AbstractInformationTypesDictionary::INFORMATION_TYPE_REVIEW);
            $collectionAccident = $collection->createInstanceByType(AbstractInformationTypesDictionary::INFORMATION_TYPE_ACCIDENT);
            $collectionUnprocessed = $collection->createInstanceByType(AbstractInformationTypesDictionary::INFORMATION_TYPE_UNPROCESSED);

            $this->saveCollectionToFile('./data/unprocessed.json', $collectionUnprocessed, $logger);
            $this->saveCollectionToFile('./data/review.json', $collectionReview, $logger);
            $this->saveCollectionToFile('./data/accident.json', $collectionAccident, $logger);

        } catch (FileException | DecoderException | Exception $e) {
            $logger->error($e->getMessage());

            return Command::FAILURE;
        }

        $logger->info(sprintf("Command %s executed successfully.", self::$defaultName));

        $output->writeln(
            [
                '------',
                sprintf('Parsed messages: %d', $collection->count()),
                sprintf('Created reviews: %d', $collectionReview->count()),
                sprintf('Created accidents: %d', $collectionAccident->count()),
                sprintf('Created unprocessed: %d', $collectionUnprocessed->count()),
            ]
        );
        foreach ($collectionUnprocessed->toArray() as $unprocessed) {
            $output->writeln(sprintf('Unprocessed: %d. Reason: %s', $unprocessed['number'], $unprocessed['reason']));
        }

        return Command::SUCCESS;
    }

    /**
     * @param string $filePath
     * @param InformationCollection $collection
     * @param LoggerInterface $logger
     * @throws EncoderException
     * @throws FileException
     */
    private function saveCollectionToFile(string $filePath, InformationCollection $collection, LoggerInterface $logger): void
    {
        $file = new JsonFile($filePath);
        $writer = new FileWriter($file, new FileSystemAdapter());

        $logger->notice(sprintf('Save collection to file: %s', $file->getFilePath()));

        (new FileWriterEncoderService($file, $writer))->run($collection->toArray());
    }
}