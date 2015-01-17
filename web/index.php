<?php
use Example\AppKernel;
use Example\ExampleClass;

require_once(realpath(__DIR__) . '/../vendor/autoload.php');
$app = new AppKernel();
$app->load();

$ec = new ExampleClass();
$ec->main();
