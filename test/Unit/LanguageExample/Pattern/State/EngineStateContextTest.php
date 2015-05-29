<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample\Pattern\Observer;

use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\EngineStateContext;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\OffState;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\RunningState;
use PHPUnit_Framework_TestCase;

class EngineStateContextText extends PHPUnit_Framework_TestCase
{
    /**
     * @outputBuffering enabled
     */
    public function testStartWhenEngineIsOff()
    {
        $context = new EngineStateContext();
        $context->start();

        $this->assertAttributeEquals(new RunningState(), 'state', $context);
        $this->expectOutputString('Engine started.');
    }

    /**
     * @outputBuffering enabled
     */
    public function testStopWhenEngineIsOn()
    {
        $context = new EngineStateContext();
        $context->start();

        $context->stop();

        $this->assertAttributeEquals(new OffState(), 'state', $context);
        $this->expectOutputString('Engine started.Engine stopped.');
    }

    public function testSetStateToRunning()
    {
        $context = new EngineStateContext();

        $context->setState(new RunningState());

        $this->assertAttributeEquals(new RunningState(), 'state', $context);
    }

    public function testSetStateToOff()
    {
        $context = new EngineStateContext();

        $context->setState(new OffState());

        $this->assertAttributeEquals(new OffState(), 'state', $context);
    }
}
