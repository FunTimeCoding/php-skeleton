<?php
use Example\Kernel;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require_once(realpath(__DIR__) . '/../vendor/autoload.php');

$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler());
$whoops->register();

$kernel = new Kernel();
$exitCode = $kernel->main();

exit($exitCode);
