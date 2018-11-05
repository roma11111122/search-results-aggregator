<?php

namespace Roma11111122\SearchResultAggregator\SearchEngine;

class SearchResultList
{
    public $searchResult;

    /**
     * @param SearchResultItem $searchResultItem
     */
    public function addSearchResultItem(SearchResultItem $searchResultItem): void
    {
        $this->searchResult[] = $searchResultItem;
    }

}