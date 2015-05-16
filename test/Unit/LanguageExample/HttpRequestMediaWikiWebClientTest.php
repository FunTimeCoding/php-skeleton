<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample;

use FunTimeCoding\PhpSkeleton\LanguageExample\HttpRequestMediaWikiWebClient;
use PHPUnit_Framework_TestCase;

class HttpRequestMediaWikiWebClientTest extends PHPUnit_Framework_Testcase
{
    public function testLoginWithHttpRequestLibrary()
    {
        $client = new HttpRequestMediaWikiWebClient('mediawiki.dev');
        $this->assertNotNull($client);
    }

    public function testQueryData()
    {
        $client = new HttpRequestMediaWikiWebClient('mediawiki.dev');
        $helper = new MediaWikiHelper();
        $queryData = $client->getLoginUrlQueryData();
        $this->assertTrue($helper->validateQueryData($queryData));
    }
}
