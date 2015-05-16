<?php
namespace FunTimeCoding\PhpSkeleton\Test\Unit\LanguageExample;

use PHPUnit_Framework_TestCase;

class MediaWikiHelperTest extends PHPUnit_Framework_Testcase
{
    public function testValid()
    {
        $helper = new MediaWikiHelper();

        $queryData = array(
            'title' => 'value_not_tested',
            'action' => 'value_not_tested',
            'type' => 'value_not_tested'
        );

        $this->assertTrue($helper->validateQueryData($queryData));
    }

    public function testTitleMissing()
    {
        $helper = new MediaWikiHelper();

        $actionMissing = array(
            'action' => 'value_not_tested',
            'type' => 'value_not_tested'
        );

        $this->assertFalse($helper->validateQueryData($actionMissing));
    }

    public function testActionMissing()
    {
        $helper = new MediaWikiHelper();

        $actionMissing = array(
            'title' => 'value_not_tested',
            'type' => 'value_not_tested'
        );

        $this->assertFalse($helper->validateQueryData($actionMissing));
    }

    public function testTypeMissing()
    {
        $helper = new MediaWikiHelper();

        $actionMissing = array(
            'title' => 'value_not_tested',
            'action' => 'value_not_tested'
        );

        $this->assertFalse($helper->validateQueryData($actionMissing));
    }
}
