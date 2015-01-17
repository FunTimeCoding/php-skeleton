<?php
namespace Example;

use Exception;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class AppKernel
{
    const EXIT_CODE_OK = 0;
    const EXIT_CODE_ERROR = 1;
    const PROJECT_ROOT_MARKER_FILE = 'README.md';
    private $exitCode = 0;

    public function __construct()
    {
        $this->exitCode = self::EXIT_CODE_OK;
    }

    private function configureErrorHandler()
    {
        $whoops = new Run();

        if ('cli' == PHP_SAPI) {
            $handler = new PlainTextHandler();
        } else {
            $handler = new PrettyPageHandler();
        }

        $whoops->pushHandler($handler);
        $whoops->register();
    }

    /**
     * @return int
     */
    public function load()
    {
        $this->configureErrorHandler();

        return $this->exitCode;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getProjectRoot()
    {
        $projectRoot = '';
        $currentDirectory = __DIR__;
        $foundRoot = false;

        while ($currentDirectory != '/') {
            $foundRoot = $this->isFileInDirectory(self::PROJECT_ROOT_MARKER_FILE, $currentDirectory);

            if ($foundRoot) {
                $projectRoot = $currentDirectory;
                break;
            }

            $currentDirectory = realpath($currentDirectory . DIRECTORY_SEPARATOR . '../');
        }

        if (!$foundRoot) {
            throw new Exception('Could not determine project root.');
        }

        return $projectRoot;
    }

    /**
     * @param string $fileName
     * @param string $directory
     * @return bool
     */
    private function isFileInDirectory($fileName, $directory)
    {
        $result = false;
        $directoryContents = scandir($directory);

        foreach ($directoryContents as $element) {
            if ($element == $fileName) {
                $result = true;
                break;
            }
        }

        return $result;
    }
}
