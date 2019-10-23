<?php

namespace App\Service;

use Elastica\Client;
use Symfony\Component\Yaml\Yaml;

class IndexBuilder
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function createBrand()
    {
        // We name our index "blog"
        $index = $this->client->getIndex('brand');

        $settings = Yaml::parse(
            file_get_contents(
                __DIR__.'/../../config/elasticsearch_index_brand.yaml'
            )
        );

        // We build our index settings and mapping
        $index->create($settings, true);

        return $index;
    }
    public function createPattern()
    {
        // We name our index "blog"
        $index = $this->client->getIndex('pattern');

        $settings = Yaml::parse(
            file_get_contents(
                __DIR__.'/../../config/elasticsearch_index_pattern.yaml'
            )
        );

        // We build our index settings and mapping
        $index->create($settings, true);

        return $index;
    }
}
