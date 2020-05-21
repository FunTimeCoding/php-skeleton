<?php

declare(strict_types=1);

namespace FunTimeCoding\PhpSkeleton\Test\Unit;

use FunTimeCoding\PhpSkeleton\PhpSkeleton;
use PHPUnit\Framework\TestCase;

use const PHP_EOL;

class PhpSkeletonTest extends TestCase
{
    /**
     * @outputBuffering enabled
     */
    public function testMainMethod(): void
    {
        $application = new PhpSkeleton();

        self::assertSame(0, $application->main());

        $this->expectOutputString('Hello friend.' . PHP_EOL);
    }
}
