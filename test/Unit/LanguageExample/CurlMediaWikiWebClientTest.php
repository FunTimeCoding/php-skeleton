<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample;

use FunTimeCoding\PhpSkeleton\LanguageExample\CurlMediaWikiWebClient;
use PHPUnit_Framework_TestCase;

class CurlMediaWikiWebClientTest extends PHPUnit_Framework_Testcase
{
    public function testExists()
    {
        $client = new CurlMediaWikiWebClient('mediawiki.dev');
        $this->assertNotNull($client);
    }

    public function testQueryData()
    {
        $client = new CurlMediaWikiWebClient('mediawiki.dev');
        $helper = new MediaWikiHelper();
        $queryData = $client->getLoginUrlQueryData();
        $this->assertTrue($helper->validateQueryData($queryData));
    }
}
