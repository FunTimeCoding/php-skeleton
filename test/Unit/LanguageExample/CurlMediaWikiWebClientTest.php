<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample;

use FunTimeCoding\PhpSkeleton\LanguageExample\CurlMediaWikiWebClient;
use FunTimeCoding\PhpSkeleton\LanguageExample\MediaWikiHelper;
use PHPUnit_Framework_TestCase;

class CurlMediaWikiWebClientTest extends PHPUnit_Framework_TestCase
{
    public function testExists()
    {
        $client = new CurlMediaWikiWebClient('mediawiki.dev');
        $this->assertNotNull($client);
    }
}
