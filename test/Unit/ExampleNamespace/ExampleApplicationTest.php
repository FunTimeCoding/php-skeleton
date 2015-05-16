<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\ExampleNamespace;

use FunTimeCoding\PhpSkeleton\ExampleNamespace\ExampleApplication;
use PHPUnit_Framework_TestCase;

class ExampleApplicationTest extends PHPUnit_Framework_TestCase
{
    public function testMainMethod()
    {
        $app = new ExampleApplication();
        $this->assertSame(0, $app->main());
    }
}
