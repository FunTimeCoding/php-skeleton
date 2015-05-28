<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State;

interface EngineState
{
    /**
     * @param EngineStateContext $context
     * @return void
     */
    public function start(EngineStateContext $context);

    /**
     * @param EngineStateContext $context
     * @return void
     */
    public function stop(EngineStateContext $context);
}
