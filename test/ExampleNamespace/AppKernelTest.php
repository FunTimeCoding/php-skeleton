<?php
namespace ExampleNamespace;

use PHPUnit_Framework_TestCase;

class AppKernelTest extends PHPUnit_Framework_Testcase
{
    public function testLoadReturnsZero()
    {
        $kernel = new AppKernel();
        $this->assertSame(0, $kernel->load());
    }

    public function testGetProjectRoot()
    {
        $kernel = new AppKernel();
        $projectRoot = $kernel->getProjectRoot();
        $this->assertNotSame('', $projectRoot);
    }

    public function testCommandLineCallOfIndex()
    {
        $kernel = new AppKernel();
        $projectRoot = $kernel->getProjectRoot();

        $command = 'php ' . $projectRoot . '/web/index.php';
        $output = array();
        $returnCode = -1;
        exec($command, $output, $returnCode);

        $this->assertNotEmpty($output, 'page should never be blank');
        $this->assertSame(0, $returnCode);
    }
}
