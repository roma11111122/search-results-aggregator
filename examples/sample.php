<?php
require_once '../vendor/autoload.php';

use \Roma11111122\SearchResultAggregator\SearchAggregator;

//why search keyword in constructor 
//what will be if I whant to search several time
$aggregator = new SearchAggregator('python');
//why not to use keyword here getAggregatedData(string $keyword)
$result = $aggregator->getAggregatedData();
echo var_dump($result);
