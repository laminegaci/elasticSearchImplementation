<?php

namespace App\Search;

use Elastic\Elasticsearch\Client;

class ElasticsearchObserver
{
    public function __construct(private Client $elasticsearchClient)
    {
        // ...
    }

    public function saved($model)
    {
        $model->elasticSearchIndex($this->elasticsearchClient);
    }

    public function deleted($model)
    {
        $model->elasticSearchDelete($this->elasticsearchClient);
    }
}