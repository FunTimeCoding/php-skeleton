<?php

namespace FunTimeCoding\PhpSkeleton\Web;

use FunTimeCoding\PhpSkeleton\ExampleNamespace\ExampleApplication;

require_once realpath(__DIR__).'/../vendor/autoload.php';

$application = new ExampleApplication();
$application->main();
