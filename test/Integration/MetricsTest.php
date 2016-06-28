<?php
namespace FunTimeCoding\PhpSkeleton\Test\Integration\LanguageExample;

use DirectoryIterator;
use PHPUnit_Framework_TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class MetricsTest extends PHPUnit_Framework_TestCase
{
    public function testInheritanceCapitalization()
    {
        // Find wrongly spelled TestCase with a lower capital c. Causes problems with phploc.

        $testDirectory = realpath(__DIR__.DIRECTORY_SEPARATOR.'..');
        $this->assertStringStartsWith('/', $testDirectory);
        $this->assertEquals('test', basename($testDirectory));

        $files = array();
        $directoryIterator = new RecursiveDirectoryIterator($testDirectory, RecursiveDirectoryIterator::SKIP_DOTS);
        $iteratorIterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::SELF_FIRST);
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

            if ($handle) {
                $found = false;
                while (($line = fgets($handle)) !== false) {
                    if ($this->startsWith($line, 'class ')) {
                        $found = true;
                        $line = trim($line);
                        $this->assertStringEndsWith(' extends PHPUnit_Framework_TestCase', $line);

                        break;
                    }
                }

                if (!$found) {
                    $this->fail('No line starts with \'class\' in '.$file);
                }

                fclose($handle);
            } else {
                $this->fail('Could not read '.$file);
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
        $length = strlen($needle);

        return substr($haystack, 0, $length) === $needle;
    }
}
