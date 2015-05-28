<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample\Pattern\Observer;

use Exception;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\EngineStateContext;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\StateOff;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\StateRunning;
use PHPUnit_Framework_TestCase;

class StateOffTest extends PHPUnit_Framework_TestCase
{
    public function testCanInstantiate()
    {
        $state = new StateOff();

        $this->assertNotNull($state);
    }

    /**
     * @outputBuffering enabled
     */
    public function testStart()
    {
        $state = new StateOff();
        $context = new EngineStateContext();

        $state->start($context);

        $this->assertAttributeEquals(new StateRunning(), 'state', $context);
        $this->expectOutputString('Engine started.');
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Cannot stop a stopped engine.
     */
    public function testStop()
    {
        $state = new StateOff();
        $context = new EngineStateContext();

        $state->stop($context);
    }
}
