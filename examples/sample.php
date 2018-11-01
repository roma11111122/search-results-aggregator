<?php
require_once '../vendor/autoload.php';

use \Roma11111122\SearchResultAggregator\SearchAggregator;


$aggregator = new SearchAggregator('python');
$result = $aggregator->getAggregatedData();
echo var_dump($result);