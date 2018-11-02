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
     * @param string $searchQuery
     * @param string $engineName
     * @param array $options
     */
    public function __construct(string $searchQuery, string $engineName, array $options)
    {
        $this->searchQuery = $searchQuery;
        $this->engineName = $engineName;
        $this->options = $options;
        $this->httpClient = new \GuzzleHttp\Client();
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSearchResultData(): array
    {

        $parameters = [
            'query' => [
                'q'   => $this->searchQuery,
                'key' => $this->options['api_key'],
                'cx'  => $this->options['cx']
            ]
        ];

        $request = $this->httpClient->request('GET', $this->options['base_url'], $parameters);

        $data = $request->getBody();

        $data = json_decode($data, true);

        $result = [];

        foreach ($data['items'] as $item) {
            $result[] = [
                //why array in this case i need to now keys but i don't whant to do it i like objects
                'title'         => $item['title'],
                'url'           => $item['link'],
                'result_source' => $this->engineName
            ];
        }

        return $result;
    }

}
