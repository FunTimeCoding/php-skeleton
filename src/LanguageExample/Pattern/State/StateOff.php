<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State;

use Exception;

class StateOff implements EngineState
{
    /**
     * @param EngineStateContext $context
     */
    public function start(EngineStateContext $context)
    {
        $context->setState(new StateRunning());
        echo 'Engine started.';
    }

    /**
     * @param EngineStateContext $context
     * @throws Exception
     */
    public function stop(EngineStateContext $context)
    {
        throw new Exception('Cannot stop a stopped engine.');
    }
}
