<?php
require_once '../vendor/autoload.php';

use Roma11111122\SearchResultAggregator\SearchAggregator;
use Roma11111122\SearchResultAggregator\Serializer\SearchResultSerializer;

$aggregator = new SearchAggregator();

$result = $aggregator->getAggregatedData('python');

$serializer = new SearchResultSerializer();

$withoutDuplicate = $serializer->removeDuplicated($result);

var_dump($withoutDuplicate);
