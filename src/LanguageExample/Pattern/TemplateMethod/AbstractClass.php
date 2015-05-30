<?php

namespace FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\TemplateMethod;

abstract class AbstractClass
{
    /**
     * The point is that this method always remains the same.
     *
     * @return int
     */
    public final function templateMethod()
    {
        return 0;
    }

    public abstract function anotherMethod();
}
