<?php

namespace Roma11111122\SearchResultAggregator\SearchEngine;

use Sunra\PhpSimple\HtmlDomParser;

class YahooSearchEngine implements SearchEngineInterface
{

    protected $engineName;

    protected $searchQuery;

    protected $httpClient;

    protected $options;

    /**
     * YahooSearchEngine constructor.
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
                'p' => $searchQuery
            ]
        ];

        $request = $this->httpClient->request('GET', $this->options['base_url'], $parameters);

        $data = $request->getBody();

        $html = $this->parseHtml($data);

        foreach ($html->find('h3.title') as $article) {

            $title = $article->find('a.ac-algo', 0)->plaintext;

            $url = $article->find('a.ac-algo', 0)->href;

            if (!empty($title) && !empty($url)) {

                $resultItem = new SearchResultItem($title, $url, $this->engineName);

                $searchResultList->addSearchResultItem($resultItem);
            }

        }

        return $searchResultList;
    }

    protected function parseHtml(string $html): \simplehtmldom_1_5\simple_html_dom
    {
        return HtmlDomParser::str_get_html($html);
    }

}
