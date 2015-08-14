<?php

namespace FunTimeCoding\PhpSkeleton\Web;

use FunTimeCoding\PhpSkeleton\PhpSkeleton;

require_once realpath(__DIR__).'/../vendor/autoload.php';

$application = new PhpSkeleton();
$application->main();
