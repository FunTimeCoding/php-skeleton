<?php
namespace FunTimeCoding\PhpSkeleton\Test\Integration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class WebTest extends TestCase
{
    /**
     * @var Process
     */
    private static $process;

    public static function setUpBeforeClass(): void
    {
        self::$process = new Process(
            ['php', '-S', 'localhost:8080', '-t', 'web']
        );
        self::$process->start();
        usleep(100000);
    }

    public static function tearDownAfterClass(): void
    {
        self::$process->stop();
    }

    public function testIndex(): void
    {
        $this->assertEquals(
            'Hello friend.' . PHP_EOL,
            file_get_contents('http://localhost:8080')
        );
    }
}
