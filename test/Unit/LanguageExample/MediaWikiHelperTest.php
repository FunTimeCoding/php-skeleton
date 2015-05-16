<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample;

use FunTimeCoding\PhpSkeleton\LanguageExample\MediaWikiHelper;
use PHPUnit_Framework_TestCase;

class MediaWikiHelperTest extends PHPUnit_Framework_TestCase
{
    public function testQueryData()
    {
        $wikiHelper = new MediaWikiHelper();
        $testHelper = new MediaWikiTestHelper();
        $queryData = $wikiHelper->getLoginUrlQueryData();
        $this->assertTrue($testHelper->validateQueryData($queryData));
    }
}
