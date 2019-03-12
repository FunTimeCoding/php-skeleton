<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample;

use FunTimeCoding\PhpSkeleton\RuntimeException;

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
     * @throws RuntimeException
     */
    public function divide(float $dividend, float $divisor): float
    {
        if ($divisor === 0.0) {
            throw new RuntimeException('Division by zero.');
        }

        return $dividend / $divisor;
    }
}
