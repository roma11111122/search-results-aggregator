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
                'p' => $this->searchQuery
            ]
        ];

        $request = $this->httpClient->request('GET', $this->options['base_url'], $parameters);

        $data = $request->getBody();

        $html = $this->parse_html($data);

        $result = [];

        foreach ($html->find('h3.title') as $article) {

            $title = $article->find('a.ac-algo', 0)->plaintext;

            $url = $article->find('a.ac-algo', 0)->href;

            if (!empty($title) && !empty($url)) {

                $result[] = [
                    'title'         => $title,
                    'url'           => $url,
                    'result_source' => $this->engineName,
                ];

            }

        }

        return $result;
    }

    public function parse_html($html): \simplehtmldom_1_5\simple_html_dom
    {
        return HtmlDomParser::str_get_html($html);
    }

}