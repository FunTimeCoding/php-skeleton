<?php

declare(strict_types=1);

namespace FunTimeCoding\PhpSkeleton\LanguageExample;

use FunTimeCoding\PhpSkeleton\RuntimeException;

class Calculator
{
    public function add(float $augend, float $addend) : float
    {
        return $augend + $addend;
    }

    /**
     * @throws RuntimeException
     */
    public function divide(float $dividend, float $divisor) : float
    {
        if ($divisor === 0.0) {
            throw new RuntimeException('Division by zero.');
        }

        return $dividend / $divisor;
    }
}
