<?php

declare(strict_types=1);

namespace FunTimeCoding\PhpSkeleton\Test\Integration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;
use const PHP_EOL;
use function file_get_contents;
use function trim;
use function usleep;

class WebTest extends TestCase
{
    /** @var Process */
    private static $process;

    /** @var string */
    private static $authority;

    public static function setUpBeforeClass() : void
    {
        $portFinder = new Process(['script/find-unused-port.py']);
        $portFinder->run();
        self::$authority = 'localhost:' . trim($portFinder->getOutput());

        self::$process = new Process(
            ['php', '-S', self::$authority, '-t', 'web']
        );
        self::$process->start();
        usleep(100000);
    }

    public static function tearDownAfterClass() : void
    {
        self::$process->stop();
    }

    public function testIndex() : void
    {
        $this::assertEquals(
            'Hello friend.' . PHP_EOL,
            file_get_contents('http://' . self::$authority)
        );
    }
}
