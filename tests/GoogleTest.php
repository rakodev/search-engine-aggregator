<?php

namespace SearchEngineAggregator\Test;


use SearchEngineAggregator\Google;
use SearchEngineAggregator\Requester;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class GoogleTest
 * @package SearchEngineAggregator\Test
 */
class GoogleTest extends \PHPUnit_Framework_TestCase
{
    /** @var Google */
    protected $google;

    public function setUp()
    {
        parent::setUp();
        $this->google = new Google(new Requester());
    }


    public function testSetAndGetQueryString()
    {
        $queryString = 'PHP Array';
        $this->google->setQueryString($queryString);
        $this->assertEquals($queryString,$this->google->getQueryString());
    }

    public function testGetContent()
    {
        $queryString = 'PHP Array';
        $this->google->setQueryString($queryString);
        $crawler = $this->google->getContent();
        $this->assertInstanceOf(Crawler::class, $crawler);
    }

    public function testGetLinks()
    {
        $queryString = 'PHP Array';
        $this->google->setQueryString($queryString);
        $result = $this->google->getLinks();
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