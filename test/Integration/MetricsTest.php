<?php

declare(strict_types=1);

namespace FunTimeCoding\PhpSkeleton\Test\Integration;

use Exception;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function basename;
use function fclose;
use function fgets;
use function fopen;
use function realpath;
use function strlen;
use function strpos;
use function substr;
use function trim;

use const DIRECTORY_SEPARATOR;

class MetricsTest extends TestCase
{
    /**
     * Find wrongly capitalized TestCase with a lower case c, which causes problems with phploc.
     *
     * @throws Exception
     */
    public function testInheritanceCapitalization(): void
    {
        $testDirectory = '' . realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
        self::assertStringStartsWith('/', $testDirectory);
        self::assertEquals('test', basename($testDirectory));

        foreach (self::collectFiles($testDirectory) as $file) {
            $handle = fopen($file, 'rb');

            if ($handle !== false) {
                $found = false;

                while (($line = fgets($handle)) !== false) {
                    if (self::startsWith('' . $line, 'class ')) {
                        $found = true;
                        self::assertStringEndsWith(' extends TestCase', trim('' . $line));

                        break;
                    }
                }

                if ($found === false) {
                    self::fail('No line starts with \'class\' in ' . $file);
                }

                fclose($handle);
            } else {
                self::fail('Could not read ' . $file);
            }
        }
    }

    /**
     * @return string[]
     */
    public static function collectFiles(string $testDirectory): array
    {
        $files = [];

        $iteratorIterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $testDirectory,
                RecursiveDirectoryIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iteratorIterator as $item) {
            /** @var SplFileInfo $item */
            if (!self::isFile($item)) {
                continue;
            }

            $filename = self::getFileName($item);

            if (!self::endsWith($filename, 'Test.php')) {
                continue;
            }

            $files[] = self::getPathName($item);
        }

        return $files;
    }

    public static function isFile(SplFileInfo $iterator): bool
    {
        return $iterator->isFile();
    }

    public static function getFileName(SplFileInfo $iterator): string
    {
        return $iterator->getFilename();
    }

    public static function endsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);

        if ($length === 0) {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }

    public static function getPathName(SplFileInfo $iterator): string
    {
        return $iterator->getPathname();
    }

    public static function startsWith(string $haystack, string $needle): bool
    {
        return strpos($haystack, $needle) === 0;
    }
}
