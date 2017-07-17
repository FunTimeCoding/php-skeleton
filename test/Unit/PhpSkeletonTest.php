<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit;

use FunTimeCoding\PhpSkeleton\PhpSkeleton;
use PHPUnit\Framework\TestCase;

class PhpSkeletonTest extends TestCase
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
