<?php

declare(strict_types=1);

namespace FunTimeCoding\PhpSkeleton\Benchmark;

use FunTimeCoding\PhpSkeleton\PhpSkeleton;

class ExampleBench
{
    public function benchMainMethod() : void
    {
        $application = new PhpSkeleton();
        $application->main();
    }
}
