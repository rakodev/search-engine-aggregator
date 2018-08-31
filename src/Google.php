<?php

namespace SearchEngineAggregator;


use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Google
 * @package SearchEngineAggregator
 */
class Google implements SearchEngineInterface
{
    /** @var string  */
    protected $sourceName = 'Google';

    /** @var string  */
    protected $baseUri = 'https://www.google.com/search?hl=en&';

    /** @var Requester  */
    protected $requester;

    /** @var string */
    protected $queryString;

    /**
     * Google constructor.
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
        $uri = $this->baseUri.http_build_query(array('q' => $this->getQueryString()));
        return $this->requester->getContent('GET', $uri);
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        $content = $this->getContent();

        $links = $content->filter('div#search div.g')->each(function (Crawler $content) {
            $url = str_replace(' ', '', $content->filter('cite')->text());
            if(strpos($url, 'http') !== 0)
            {
                $url = 'http://'.$url;
            }
            return [
                'source' => [$this->sourceName],
                'title' => $content->filter('a')->text(),
                'url' => $url,
                'host' => parse_url($url, PHP_URL_HOST)
            ];
        });
        return $links;
    }
}