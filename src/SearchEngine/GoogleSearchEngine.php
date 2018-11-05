<?php

namespace Roma11111122\SearchResultAggregator\SearchEngine;

class GoogleSearchEngine implements SearchEngineInterface
{

    protected $searchQuery;

    protected $httpClient;

    protected $engineName;

    protected $options;

    /**
     * GoogleSearchEngine constructor.
     * @param string $engineName
     * @param array $options
     */
    public function __construct(string $engineName, array $options)
    {
        $this->engineName = $engineName;
        $this->options = $options;
        $this->httpClient = new \GuzzleHttp\Client();
    }

    /**
     * @param $searchQuery
     * @param SearchResultList $searchResultList
     * @return SearchResultList
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSearchResultData($searchQuery, SearchResultList $searchResultList): SearchResultList
    {

        $parameters = [
            'query' => [
                'q'   => $searchQuery,
                'key' => $this->options['api_key'],
                'cx'  => $this->options['cx']
            ]
        ];

        $request = $this->httpClient->request('GET', $this->options['base_url'], $parameters);

        $data = $request->getBody();

        $data = json_decode($data, true);

        foreach ($data['items'] as $item) {

            $resultItem = new SearchResultItem($item['title'], $item['link'], $this->engineName);

            $searchResultList->addSearchResultItem($resultItem);

        }

        return $searchResultList;
    }

}
