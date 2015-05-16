<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\Framework;

use FunTimeCoding\PhpSkeleton\Framework\Kernel;
use PHPUnit_Framework_TestCase;

class KernelTest extends PHPUnit_Framework_Testcase
{
    public function testLoadReturnsZero()
    {
        $kernel = new Kernel();
        $this->assertSame(0, $kernel->load());
    }

    public function testGetProjectRoot()
    {
        $kernel = new Kernel();
        $projectRoot = $kernel->getProjectRoot();
        $this->assertNotEmpty($projectRoot);
    }

    public function testCommandLineCallOfIndex()
    {
        $kernel = new Kernel();
        $projectRoot = $kernel->getProjectRoot();

        $command = 'php ' . $projectRoot . '/web/index.php';
        $output = array();
        $returnCode = -1;
        exec($command, $output, $returnCode);

        $this->assertNotEmpty($output, 'page should never be blank');
        $this->assertSame(0, $returnCode);
    }
}
