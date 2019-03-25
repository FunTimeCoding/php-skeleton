<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample;

use FunTimeCoding\PhpSkeleton\RuntimeException;
use FunTimeCoding\PhpSkeleton\LanguageExample\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAddPositiveNumbers(): void
    {
        $calculator = new Calculator();

        $result = $calculator->add(1, 2);

        self::assertEquals(3, $result);
    }

    public function testAddNegativeNumbers(): void
    {
        $calculator = new Calculator();

        $result = $calculator->add(-1, -2);

        self::assertEquals(-3, $result);
    }

    /**
     * @throws RuntimeException
     */
    public function testDivideEqualNumbers(): void
    {
        $calculator = new Calculator();

        $result = $calculator->divide(2, 2);

        self::assertEquals(1, $result);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Division by zero.
     */
    public function testDivideByZero(): void
    {
        $calculator = new Calculator();

        $calculator->divide(2, 0);
    }
}
