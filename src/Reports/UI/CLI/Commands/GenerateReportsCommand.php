<?php

declare(strict_types=1);

namespace App\Reports\UI\CLI\Commands;

use App\Common\Adapters\FileSystemAdapter;
use App\Common\Exceptions\DecoderException;
use App\Common\Exceptions\FileException;
use App\Common\Readers\FileReader;
use App\Common\Services\FileReaderDecoderService;
use App\Common\ValueObjects\JsonFile;
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
        try {
            $data = $fileDecoderService->run();
        } catch (FileException | DecoderException $e) {
            echo 'error' . $e->getMessage();
            exit();
        }

        return Command::SUCCESS;
    }
}