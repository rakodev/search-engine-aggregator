<?php
namespace SearchEngineAggregator;

/**
 * Class Search
 * @package SearchEngineAggregator
 */
class Search
{
    /** @var Requester  */
    protected $requester;

    /** @var string */
    protected $queryString;

    /** @var array  */
    protected $searchEngines = ['Google', 'Yahoo'];

    /**
     * Search constructor.
     */
    public function __construct()
    {
        $this->requester = new Requester();
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
     * @return array
     */
    public function getContent()
    {
        $results = [];
        foreach ($this->searchEngines as $searchEngine)
        {
            $className = '\SearchEngineAggregator\\'.$searchEngine;
            /** @var SearchEngineInterface $engine */
            $engine = new $className($this->requester);

            $engine->setQueryString($this->queryString);

            $results = array_merge($results, $engine->getLinks());
        }

        return $this->mergeDuplicate($results);

    }

    /**
     * @param array $results
     * @return array
     */
    public function mergeDuplicate(array $results)
    {
        $finalResult = [];
        foreach ($results as $result)
        {
            sort($finalResult);
            if ($key = array_search(parse_url($result['url'], PHP_URL_HOST), array_column($finalResult, 'host')) !== false){
                if(in_array($result['source'][0], $finalResult[($key-1)]['source'])) {
                    continue;
                }
                array_push($finalResult[($key-1)]['source'], $result['source'][0]);
            } else {
                array_push($finalResult, $result);
            }
        }

        return $finalResult;
    }
}