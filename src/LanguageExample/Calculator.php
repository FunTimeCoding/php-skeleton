<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample;

use Exception;

class Calculator
{
    public function add(float $augend, float $addend): float
    {
        return $augend + $addend;
    }

    /**
     * @param float $dividend
     * @param float $divisor
     *
     * @return float
     * @throws Exception
     */
    public function divide(float $dividend, float $divisor): float
    {
        if ($divisor == 0) {
            throw new Exception('Division by zero.');
        }

        return $dividend / $divisor;
    }
}
