<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\State;

/**
 * This could also be an abstract class instead of an interface. The state pattern would still be valid.
 */
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
