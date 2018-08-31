<?php

namespace SearchEngineAggregator\Test;


use SearchEngineAggregator\Requester;
use SearchEngineAggregator\Search;

/**
 * Class SearchTest
 * @package SearchEngineAggregator\Test
 */
class SearchTest extends \PHPUnit_Framework_TestCase
{
    /** @var Search */
    protected $search;

    public function setUp()
    {
        parent::setUp();
        $this->search = new Search();
    }

    public function testSetAndGetQueryString()
    {
        $queryString = 'PHP Array';
        $this->search->setQueryString($queryString);
        $this->assertEquals($queryString,$this->search->getQueryString());
    }

    public function testMergeDuplicate()
    {
        $array = [
            [
                'source' => ['Google'],
                'title' => 'Title 1',
                'url' => 'http://www.domain1.com/page',
                'host' => 'www.domain1.com'
            ],
            [
                'source' => ['Google'],
                'title' => 'Title 2',
                'url' => 'http://www.domain2.com/page',
                'host' => 'www.domain2.com'
            ],
            [
                'source' => ['Yahoo'],
                'title' => 'Title 1',
                'url' => 'http://www.domain1.com/page/ok',
                'host' => 'www.domain1.com'
            ]
        ];
        $mergedArray = $this->search->mergeDuplicate($array);
        $this->assertEquals(2, count($mergedArray));
        foreach ($mergedArray as $item)
        {
            if($item['host'] == 'www.domain1.com') {
                $this->assertEquals(2, count($item['source']));
            }
        }
    }

    public function testGetContent()
    {
        $this->search->setQueryString('PHP');
        $result = $this->search->getContent();

        $this->assertInternalType('array', $result);
        $this->assertNotEmpty($result);

        $this->search->setQueryString('');
        $result = $this->search->getContent();

        $this->assertInternalType('array', $result);
        $this->assertEmpty($result);
    }
}