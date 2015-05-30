<?php

namespace FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\Bridge;

class ComputerSwitch implements SwitchBridgeInterface
{
    public function off()
    {
        echo 'Computer off.';
    }

    public function on()
    {
        echo 'Computer on.';
    }
}
