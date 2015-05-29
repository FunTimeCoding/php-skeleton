<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample\Pattern\Observer;

use Exception;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\EngineStateContext;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\OffState;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\RunningState;
use PHPUnit_Framework_TestCase;

class OffStateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @outputBuffering enabled
     */
    public function testStart()
    {
        $state = new OffState();
        $context = new EngineStateContext();

        $state->start($context);

        $this->assertAttributeEquals(new RunningState(), 'state', $context);
        $this->expectOutputString('Engine started.');
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Cannot stop a stopped engine.
     */
    public function testStop()
    {
        $state = new OffState();
        $context = new EngineStateContext();

        $state->stop($context);
    }
}
