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
        //for me its bad idea to have heavy constructor use getter will be better
        //we can have construct but not use object in this case we will do what we really no need
        $this->createSearchEngines();

    }

    //better way for getter instead setter
    private function setConfig($config): void
    {
        //what will be if we put there some config? ($config != $configFromFile)
        include('../config/config.php');
        $this->config = $config;
    }

    //what will be if I call it several time (I think better will have to getter which will create and in this case cache it to $this->searchEngines)
    private function createSearchEngines(): void
    {
        //not easy to understand what is $key => $value better to use more informative names
        foreach ($this->config as $key => $value) {
            
            $searchEngine = new $value['class']($this->searchQuery, $key, $value['options']);
            //it is not set (for me set will replace prev value)
            $this->setSearchEngine($searchEngine);
        }
    }

    //set or add? also if we will transform createSearchEngines to getSearchEngines i think we will not need it enymore
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

        //for me we can change (in future) logic of duplication or even skip it so its not responsibility of this class
        //better to return all data which we collect
        //and in main class to use some separated class to remove duplicates
        //in this case we can deside need we do it or no
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
