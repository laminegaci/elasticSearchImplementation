<?php

namespace App\Articles;

use App\Models\Article;
use Illuminate\Support\Arr;
use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;

class ElasticSearchRepository implements SearchRepository
{
    /** @var \Elasticsearch\Client */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = ''): Collection
    {
        $items = $this->searchOnElasticsearch($query);

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(string $query = '')
    {
        
        $model = new Article;

        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['body'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);

        return $items;
    }

    private function buildCollection($items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'] ?? [], '_id') ?? [];

        return Article::findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }
}