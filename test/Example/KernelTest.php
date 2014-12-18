<?php
namespace Example;

use PHPUnit_Framework_TestCase;

class KernelTest extends PHPUnit_Framework_Testcase
{
    public function testMain()
    {
        $kernel = new Kernel();
        $this->assertSame(0, $kernel->main());
    }
}
