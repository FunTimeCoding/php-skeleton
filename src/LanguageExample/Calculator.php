<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample;

use Exception;

class Calculator
{
    /**
     * @param int|float|double $augend
     * @param int|float|double $addend
     * @return int|float|double sum
     */
    public function add($augend, $addend)
    {
        return $augend + $addend;
    }

    /**
     * @param int|float|double $dividend
     * @param int|float|double $divisor
     * @return int|float|double quotient
     * @throws Exception
     */
    public function div($dividend, $divisor)
    {
        if ($divisor == 0) {
            throw new Exception('Division by zero.');
        }

        return $dividend / $divisor;
    }
}
