<?php

namespace Roma11111122\SearchResultAggregator;

use Roma11111122\SearchResultAggregator\SearchEngine\SearchEngineInterface;
use Roma11111122\SearchResultAggregator\SearchEngine\SearchResultList;

class SearchAggregator
{

    private $config;

    private $searchEngines;

    /**
     * SearchAggregator constructor.
     * @param array|null $config
     */
    public function __construct(array $config = null)
    {

        if ($config === null) {
            $this->getConfig();
        }

    }

    private function getConfig(): void
    {
        $this->config = Config::getDefaultConfig();
    }

    public function getAggregatedData(string $searchQuery): SearchResultList
    {
        if (empty($this->searchEngines)) {
            $this->getSearchEngines($searchQuery);
        }

        $searchResultList = new SearchResultList();

        foreach ($this->searchEngines as $engine) {

            $searchResultList = $engine->getSearchResultData($searchQuery, $searchResultList);

        }

        return $searchResultList;

    }

    private function getSearchEngines(): void
    {

        foreach ($this->config as $engineName => $engineConfig) {

            $searchEngine = new $engineConfig['class']($engineName, $engineConfig['options']);

            $this->addSearchEngine($searchEngine);

        }
    }

    private function addSearchEngine(SearchEngineInterface $engine): void
    {
        $this->searchEngines[] = $engine;
    }

}
