<?php

namespace Roma11111122\SearchResultAggregator\SearchEngine;

interface SearchEngineInterface
{

    /**
     * SearchEngineInterface constructor.
     * @param string $searchQuery
     * @param string $searchEngineName
     * @param array $options
     */
    public function __construct(string $searchQuery, string $searchEngineName, array $options);

    /**
     * @return  array $arr = [
     *             'title' => '',         // The title of search result
     *             'url' => '',           // The url of resource
     *             'result_source' => '', // The source of result
     *     ],
     */
    //better to have some object as result like SearchResultList which will contain SearchResult[] because
    //i can return array of apples or bananas and it will normal according to interface
    public function getSearchResultData(): array;

}
