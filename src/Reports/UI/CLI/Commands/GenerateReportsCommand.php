<?php

declare(strict_types=1);

namespace App\Reports\UI\CLI\Commands;

use App\Reports\Adapters\FileSystemAdapter;
use App\Reports\Exceptions\FileException;
use App\Reports\Readers\FileReader;
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

        $fileReader = new FileReader($sourcePath, new FileSystemAdapter());
        try {
            $fileContent = $fileReader->read();
        } catch (FileException $e) {
            echo 'error' . $e->getMessage();
            exit();
        }

        echo $fileContent;

        return Command::SUCCESS;
    }
}