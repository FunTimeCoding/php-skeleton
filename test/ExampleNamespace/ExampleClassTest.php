<?php
namespace ExampleNamespace;

use PHPUnit_Framework_TestCase;

class ExampleClassTest extends PHPUnit_Framework_TestCase
{
    public function testMainMethod()
    {
        $ec = new ExampleClass();
        $this->assertSame(0, $ec->main());
    }
}
