<?php

$config = Symfony\CS\Config\Config::create();
$config->level(Symfony\CS\FixerInterface::PSR2_LEVEL);
# Disabled psr0 because it causes strange behavior with the test namespace becoming lower capitals.
# More information on enabled fixers: https://github.com/FriendsOfPHP/PHP-CS-Fixer
$fixers = array(
    '-psr0',
    'multiline_array_trailing_comma',
    'new_with_braces',
    'no_blank_lines_before_namespace'
);
$config->fixers($fixers);
$finder = Symfony\CS\Finder\DefaultFinder::create();
# The vendor directory is excluded by default.
$finder->exclude('build');
$finder->in(__DIR__);
$config->finder($finder);

return $config;
