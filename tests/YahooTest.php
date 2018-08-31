<?php

namespace SearchEngineAggregator\Test;


use SearchEngineAggregator\Yahoo;
use SearchEngineAggregator\Requester;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class YahooTest
 * @package SearchEngineAggregator\Test
 */
class YahooTest extends \PHPUnit_Framework_TestCase
{
    /** @var Yahoo */
    protected $yahoo;

    public function setUp()
    {
        parent::setUp();
        $this->yahoo = new Yahoo(new Requester());
    }

    public function testSetAndGetQueryString()
    {
        $queryString = 'PHP Array';
        $this->yahoo->setQueryString($queryString);
        $this->assertEquals($queryString,$this->yahoo->getQueryString());
    }

    public function testGetContent()
    {
        $queryString = 'PHP Array';
        $this->yahoo->setQueryString($queryString);
        $crawler = $this->yahoo->getContent();
        $this->assertInstanceOf(Crawler::class, $crawler);
    }

    public function testGetLinks()
    {
        $queryString = 'PHP Array';
        $this->yahoo->setQueryString($queryString);
        $result = $this->yahoo->getLinks();
        $this->assertInternalType('array', $result);
        if(!empty($result)) {
            $this->assertEquals(4, count($result[0]));
            $this->assertArrayHasKey('source', $result[0]);
            $this->assertArrayHasKey('title', $result[0]);
            $this->assertArrayHasKey('url', $result[0]);
            $this->assertArrayHasKey('host', $result[0]);
        }
    }
}