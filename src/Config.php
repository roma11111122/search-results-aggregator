<?php

namespace Roma11111122\SearchResultAggregator;

use Roma11111122\SearchResultAggregator\SearchEngine\GoogleSearchEngine;
use Roma11111122\SearchResultAggregator\SearchEngine\YahooSearchEngine;

class Config
{
    public static function getDefaultConfig(): array
    {
        return [

            'Google' => [
                'class'   => GoogleSearchEngine::class,
                'options' => [
                    'base_url' => 'https://www.googleapis.com/customsearch/v1',
                    'api_key'  => 'AIzaSyCRMyWWJxNefhQdPF4u5oCyyIGMTENS5xQ',
                    'cx'       => '017818119470388707944:5pvgmnpkxii'
                ]
            ],
            'Yahoo'  => [
                'class'   => YahooSearchEngine::class,
                'options' => [
                    'base_url' => 'https://search.yahoo.com/search',
                ]
            ]

        ];
    }
}