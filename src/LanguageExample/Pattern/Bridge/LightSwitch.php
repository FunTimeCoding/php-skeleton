<?php

namespace FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\Bridge;

class LightSwitch implements SwitchBridgeInterface
{
    public function off()
    {
        echo 'Light off.';
    }

    public function on()
    {
        echo 'Light on.';
    }
}
