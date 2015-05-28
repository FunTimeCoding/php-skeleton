<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State;

class EngineStateContext
{
    /**
     * @var EngineState
     */
    private $state;

    public function __construct()
    {
        $this->state = new StateOff();
    }

    /**
     * @param EngineState $state
     */
    public function setState(EngineState $state)
    {
        $this->state = $state;
    }

    public function start()
    {
        $this->state->start($this);
    }

    public function stop()
    {
        $this->state->stop($this);
    }
}
