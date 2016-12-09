<?php

# The vendor directory is excluded by default.
$finder = PhpCsFixer\Finder::create()
    ->exclude('build')
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRules(
        array(
            '@PSR2' => true,
            //'strict_param' => true,
            'array_syntax' => array('syntax' => 'short'),
        )
    )
    ->setFinder($finder);
