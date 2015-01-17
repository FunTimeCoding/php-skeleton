<?php
namespace LanguageExample;

use Exception;
use PHPUnit_Framework_TestCase;

class CalculatorTest extends PHPUnit_Framework_Testcase
{
    public function testAddPositiveNumbers()
    {
        $calc = new Calculator();
        $result = $calc->add(1, 2);
        $this->assertEquals(3, $result);
    }

    public function testAddNegativeNumbers()
    {
        $calc = new Calculator();
        $result = $calc->add(-1, -2);
        $this->assertEquals(-3, $result);
    }

    public function testDivideEqualNumbers()
    {
        $calc = new Calculator();
        $result = $calc->div(2, 2);
        $this->assertEquals(1, $result);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Division by zero.
     */
    public function testDivideByZero()
    {
        $calc = new Calculator();
        $calc->div(2, 0);
    }

    public function testAlternativeDivideByZero()
    {
        try {
            $calc = new Calculator();
            $calc->div(2, 0);
            $this->fail('Exception was not thrown.');
        } catch (Exception $e) {
            // pass test
        }
    }
}
