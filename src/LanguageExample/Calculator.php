<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample;

use Exception;

class Calculator
{
    /**
     * @param int|float|double $a
     * @param int|float|double $b
     * @return int|float|double
     */
    public function add($a, $b)
    {
        return $a + $b;
    }

    /**
     * @param int|float|double $a
     * @param int|float|double $b
     * @return int|float|double
     * @throws Exception
     */
    public function div($a, $b)
    {
        if ($b == 0) {
            throw new Exception('Division by zero.');
        }

        return $a / $b;
    }
}
