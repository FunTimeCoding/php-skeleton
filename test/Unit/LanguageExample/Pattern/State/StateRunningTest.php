<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample\Pattern\Observer;

use Exception;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\EngineStateContext;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\StateOff;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\StateRunning;
use PHPUnit_Framework_TestCase;

class StateRunningTest extends PHPUnit_Framework_TestCase
{
    public function testCanInstantiate()
    {
        $state = new StateRunning();

        $this->assertNotNull($state);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Cannot start a running engine.
     */
    public function testStart()
    {
        $state = new StateRunning();
        $context = new EngineStateContext();

        $state->start($context);
    }

    /**
     * @outputBuffering enabled
     */
    public function testStop()
    {
        $state = new StateRunning();
        $context = new EngineStateContext();

        $state->stop($context);

        $this->assertAttributeEquals(new StateOff(), 'state', $context);
        $this->expectOutputString('Engine stopped.');
    }
}
