<?php
namespace FunTimeCoding\PhpSkeleton\Test\Integration;

use Exception;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class MetricsTest extends TestCase
{
    /**
     * Find wrongly capitalized TestCase with a lower case c, which causes problems with phploc.
     * @throws Exception
     */
    public function testInheritanceCapitalization(): void
    {
        $testDirectory = '' . realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
        self::assertStringStartsWith('/', $testDirectory);
        self::assertEquals('test', basename($testDirectory));
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
            /** @var \DirectoryIterator $item */
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
                    if ($this->startsWith('' . $line, 'class ')) {
                        $found = true;
                        self::assertStringEndsWith(' extends TestCase', trim('' . $line));

                        break;
                    }
                }

                if ($found == false) {
                    self::fail('No line starts with \'class\' in ' . $file);
                }

                fclose($handle);
            } else {
                self::fail('Could not read ' . $file);
            }
        }
    }

    public function endsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);

        if ($length == 0) {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }

    public function startsWith(string $haystack, string $needle): bool
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}
