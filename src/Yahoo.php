<?php

namespace SearchEngineAggregator;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Yahoo
 * @package SearchEngineAggregator
 */
class Yahoo implements SearchEngineInterface
{
    /** @var string  */
    protected $sourceName = 'Yahoo';

    /** @var string  */
    protected $baseUri = 'https://search.yahoo.com/search?';

    /** @var Requester  */
    protected $requester;

    /** @var string */
    protected $queryString;

    /**
     * Yahoo constructor.
     * @param Requester $requester
     */
    public function __construct(Requester $requester)
    {
        $this->requester = $requester;
    }

    /**
     * @param $queryString
     */
    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @return Crawler
     */
    public function getContent()
    {
        $uri = $this->baseUri.http_build_query(array('p' => $this->getQueryString()));
        return $this->requester->getContent('GET', $uri);
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        $content = $this->getContent();

        $links = $content->filter('ol.mb-15 > li')->each(function (Crawler $content) {
            $url = str_replace(' ', '', $content->filter('h3 a')->attr('href'));
            return [
                'source' => [$this->sourceName],
                'title' => $content->filter('h3.title')->text(),
                'url' => $url,
                'host' => parse_url($url, PHP_URL_HOST)
            ];
        });
        return $links;
    }
}