<?php

namespace Roma11111122\SearchResultAggregator;

use Roma11111122\SearchResultAggregator\SearchEngine\SearchEngineInterface;

class SearchAggregator
{

    private $searchQuery;

    private $config;

    private $searchEngines;

    /**
     * SearchAggregator constructor.
     * @param string $searchQuery
     * @param array|null $config
     */
    public function __construct(string $searchQuery, array $config = null)
    {
        $this->searchQuery = $searchQuery;

        if ($config === null) {
            $this->setConfig($config);
        }
        $this->createSearchEngines();

    }

    private function setConfig($config): void
    {
        include('../config/config.php');
        $this->config = $config;
    }

    private function createSearchEngines(): void
    {
        foreach ($this->config as $key => $value) {
            $searchEngine = new $value['class']($this->searchQuery, $key, $value['options']);
            $this->setSearchEngine($searchEngine);
        }
    }

    private function setSearchEngine(SearchEngineInterface $engine): void
    {
        $this->searchEngines[] = $engine;
    }

    public function getAggregatedData(): array
    {

        $data = [];
        foreach ($this->searchEngines as $engine) {

            $result = $engine->getSearchResultData();

            $data = array_merge($data, $result);
        }

        return $this->removeDuplicated($data);

    }

    protected function removeDuplicated($data): array
    {
        $totalResult = [];

        foreach ($data as $dataItem) {
            $isDuplicate = false;
            foreach ($totalResult as $key => &$value) {

                if ($value['url'] === $dataItem['url']) {
                    $isDuplicate = true;
                    $totalResult[$key]['source'][] = $dataItem['result_source'];
                }

            }

            if ($isDuplicate === true) {
                continue;
            }

            $totalResult[] = [
                'title'  => $dataItem['title'],
                'url'    => $dataItem['url'],
                'source' => [$dataItem['result_source']],
            ];

        }

        return $totalResult;
    }
}