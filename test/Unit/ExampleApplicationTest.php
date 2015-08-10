<?php

namespace FunTimeCoding\PhpSkeleton\Test\Unit;

use FunTimeCoding\PhpSkeleton\ExampleApplication;
use PHPUnit_Framework_TestCase;

class ExampleApplicationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @outputBuffering enabled
     */
    public function testMainMethod()
    {
        $app = new ExampleApplication();

        $this->assertSame(0, $app->main());

        $this->expectOutputString('hello world'.PHP_EOL);
    }
}
