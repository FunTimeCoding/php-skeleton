<?php
namespace Example;

use Exception;

class Calculator
{
    public function add($a, $b)
    {
        return $a + $b;
    }

    public function div($a, $b)
    {
        if($b == 0)
        {
            throw new Exception('This doesn\'t look right.');
        }

        return $a / $b;
    }
}

