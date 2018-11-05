<?php

namespace Roma11111122\SearchResultAggregator\SearchEngine;

class SearchResultItem
{
    public $title;

    public $url;

    public $engineName;

    /**
     * SearchResultItem constructor.
     * @param string $title
     * @param string $url
     * @param string $engineName
     */
    public function __construct(string $title, string $url, string $engineName)
    {
        $this->title = $title;
        $this->url = $url;
        $this->engineName = $engineName;
    }


}