<?php

namespace Roma11111122\SearchResultAggregator\Serializer;

class SerializedResultItem
{
    public $title;

    public $url;

    public $source;

    /**
     * SerializedResultItem constructor.
     * @param string $title
     * @param string $url
     * @param array $source
     */
    public function __construct(string $title, string $url, array $source)
    {
        $this->title = $title;
        $this->url = $url;
        $this->source = $source;
    }

    /**
     * @param array $source
     */
    public function addSource(array $source): void
    {
        $this->source[] = $source;
    }
}