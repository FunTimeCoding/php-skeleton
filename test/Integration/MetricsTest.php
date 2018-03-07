<?php
namespace FunTimeCoding\PhpSkeleton\Test\Integration\LanguageExample;

use DirectoryIterator;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class MetricsTest extends TestCase
{
    /**
     * Find wrongly capitalized TestCase with a lower case c, which causes problems with phploc.
     */
    public function testInheritanceCapitalization()
    {
        $testDirectory = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
        $this->assertStringStartsWith('/', $testDirectory);
        $this->assertEquals('test', basename($testDirectory));
        $files = [];
        $directoryIterator = new RecursiveDirectoryIterator(
            $testDirectory,
            RecursiveDirectoryIterator::SKIP_DOTS
        );
        $iteratorIterator = new RecursiveIteratorIterator(
            $directoryIterator,
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iteratorIterator as $item) {
            /** @var DirectoryIterator $item */
            if ($item->isFile()) {
                $filename = $item->getFilename();
                if ($this->endsWith($filename, 'Test.php')) {
                    $files[] = $item->getPathname();
                }
            }
        }

        foreach ($files as $file) {
            $handle = fopen($file, 'r');

            if ($handle != false) {
                $found = false;

                while (($line = fgets($handle)) !== false) {
                    if ($this->startsWith($line, 'class ')) {
                        $found = true;
                        $this->assertStringEndsWith(' extends TestCase', trim($line));

                        break;
                    }
                }

                if ($found == false) {
                    $this->fail('No line starts with \'class\' in ' . $file);
                }

                fclose($handle);
            } else {
                $this->fail('Could not read ' . $file);
            }
        }
    }

    public function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        if ($length == 0) {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }

    public function startsWith($haystack, $needle)
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}
