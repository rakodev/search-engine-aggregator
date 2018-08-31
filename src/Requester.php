<?php

namespace SearchEngineAggregator;


use Goutte\Client;

/**
 * Class Requester
 * @package SearchEngineAggregator
 */
class Requester
{
    /**
     * @return Client
     */
    public function getClient()
    {
        return new Client();
    }

    /**
     * @param $method
     * @param $uri
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function getContent($method, $uri)
    {
        $client = $this->getClient();
        return $client->request($method, $uri);
    }

}