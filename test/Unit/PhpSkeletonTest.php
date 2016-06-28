<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit;

use FunTimeCoding\PhpSkeleton\PhpSkeleton;
use PHPUnit_Framework_TestCase;

class PhpSkeletonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @outputBuffering enabled
     */
    public function testMainMethod()
    {
        $application = new PhpSkeleton();

        $this->assertSame(0, $application->main());

        $this->expectOutputString('Hello friend.'.PHP_EOL);
    }
}
