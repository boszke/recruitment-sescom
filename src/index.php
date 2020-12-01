<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Reports\UI\CLI\Commands\GenerateReportsCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new GenerateReportsCommand());

try {
    $application->run();
} catch (Exception $e) {
    exit('Unexpected error: ' . $e->getMessage());
}