<?php

namespace SearchEngineAggregator;

/**
 * Interface SearchEngineInterface
 * @package SearchEngineAggregator
 */
interface SearchEngineInterface
{
    public function __construct(Requester $requester);

    public function getContent();

    public function setQueryString($queryString);

    public function getQueryString();

    public function getLinks();
}