<?php

namespace Roma11111122\SearchResultAggregator\SearchEngine;

interface SearchEngineInterface
{

    /**
     * SearchEngineInterface constructor.
     * @param string $searchEngineName
     * @param array $options
     */
    public function __construct(string $searchEngineName, array $options);

    /**
     * @param string $searchQuery
     * @param SearchResultList $searchResultList
     * @return SearchResultList
     */
    public function getSearchResultData(string $searchQuery, SearchResultList $searchResultList): SearchResultList;

}
