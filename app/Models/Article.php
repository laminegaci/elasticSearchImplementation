<?php

namespace App\Models;

use App\Search\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory, Searchable;

    protected $casts = [
        'tags' => 'json',
    ];

    public function getSearchIndex()
    {
        // Return the search index for the article
        return 'articles'; // Replace 'articles' with the actual name of your search index
    }
    public function getSearchType()
    {
        // Return the search type for the article
        return 'article'; // Replace 'article' with the actual name of your search type
    }

    public function toSearchArray()
    {
        // Return the article data as an array for indexing in Elasticsearch
        return [
            'title' => $this->title,
            'body' => $this->body,
            // Add more fields as needed
        ];
    }

    public function toElasticsearchDocumentArray(): array
    {
        return [];
    }
}
