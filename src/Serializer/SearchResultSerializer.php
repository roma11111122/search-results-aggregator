<?php

namespace Roma11111122\SearchResultAggregator\Serializer;

use Roma11111122\SearchResultAggregator\SearchEngine\SearchResultList;

class SearchResultSerializer
{
    public $serializedData = [];

    public function removeDuplicated(SearchResultList $data): array
    {

        foreach ($data->searchResult as $index => $dataItem) {

            $isDuplicate = false;

            foreach ($this->serializedData as $key => &$resultItem) {

                if ($dataItem->url === $resultItem->url) {

                    $isDuplicate = true;

                    $this->serializedData[$key]->source[] = $dataItem->engineName;
                }

            }
            if ($isDuplicate === true) {
                continue;
            }
            $serializedResultItem = new SerializedResultItem($dataItem->title, $dataItem->url, [$dataItem->engineName]);

            $this->addItem($serializedResultItem);

        }

        return $this->serializedData;

    }

    protected function addItem(SerializedResultItem $serializedResultItem): void
    {
        $this->serializedData[] = $serializedResultItem;
    }
}
