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
    public function getSearchResultData(): array;

}