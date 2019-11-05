<?php

declare(strict_types=1);

namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample;

use FunTimeCoding\PhpSkeleton\LanguageExample\Calculator;
use FunTimeCoding\PhpSkeleton\RuntimeException;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAddPositiveNumbers() : void
    {
        $calculator = new Calculator();

        $result = $calculator->add(1, 2);

        self::assertEquals(3, $result);
    }

    public function testAddNegativeNumbers() : void
    {
        $calculator = new Calculator();

        $result = $calculator->add(-1, -2);

        self::assertEquals(-3, $result);
    }

    public function testDivideEqualNumbers() : void
    {
        $calculator = new Calculator();

        $result = $calculator->divide(2, 2);

        self::assertEquals(1, $result);
    }

    public function testDivideByZero() : void
    {
        $calculator = new Calculator();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Division by zero.');

        $calculator->divide(2, 0);
    }
}
