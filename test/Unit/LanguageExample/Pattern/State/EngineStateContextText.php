<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample\Pattern\Observer;

use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\EngineStateContext;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\StateOff;
use FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State\StateRunning;
use PHPUnit_Framework_TestCase;

class EngineStateContextText extends PHPUnit_Framework_TestCase
{
    public function testCanInstantiate()
    {
        $context = new EngineStateContext();

        $this->assertNotNull($context);
    }

    /**
     * @outputBuffering enabled
     */
    public function testStartWhenEngineIsOff()
    {
        $context = new EngineStateContext();
        $context->start();

        $this->assertAttributeEquals(new StateRunning(), 'state', $context);
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

        $this->assertAttributeEquals(new StateOff(), 'state', $context);
        $this->expectOutputString('Engine started.Engine stopped.');
    }

    public function testSetStateToRunning()
    {
        $context = new EngineStateContext();

        $context->setState(new StateRunning());

        $this->assertAttributeEquals(new StateRunning(), 'state', $context);
    }

    public function testSetStateToOff()
    {
        $context = new EngineStateContext();

        $context->setState(new StateOff());

        $this->assertAttributeEquals(new StateOff(), 'state', $context);
    }
}
