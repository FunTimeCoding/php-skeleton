<?php

use Example\ExampleController;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require_once(realpath(__DIR__) . '/../vendor/autoload.php');

$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler());
$whoops->register();

$ctrl = new ExampleController();
$ctrl->main();

