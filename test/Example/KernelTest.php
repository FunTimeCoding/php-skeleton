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

    public function testExitCode()
    {
        $kernel = new Kernel();
        $projectRoot = $kernel->getProjectRoot();

        $command = 'php ' . $projectRoot . '/web/index.php';
        $output = array();
        $returnCode = -1;
        exec($command, $output, $returnCode);

        $this->assertEmpty($output, implode(PHP_EOL, $output));
        $this->assertSame(0, $returnCode);
    }
}
