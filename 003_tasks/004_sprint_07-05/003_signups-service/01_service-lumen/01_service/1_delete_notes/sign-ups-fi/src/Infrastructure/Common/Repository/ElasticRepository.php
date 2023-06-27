<?php

declare(strict_types=1);

namespace Infrastructure\Common\Repository;

use Elasticsearch\Client;

abstract class ElasticRepository
{
    /**
     * The Elastic Client
     *
     * @var Elasticsearch\Client
     */
    protected $client;

    /**
     * The document index
     *
     * @var string
     */
    protected $index;

    /**
     * Default Constructor
     *
     * @param Elasticsearch\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->index = $this->client->prefix . $this->index;
    }

    /**
     * Index a new document
     *
     * @param array $body
     * @param string $id
     * @return array
     */
    public function index($body, $id = null) : array
    {
        $result = $this->client->index([
            'id' => $id,
            'index' => $this->index,
            'body' => $body,
        ]);

        return $result;
    }

    /**
     * Get a existent document by id
     *
     * @todo Clean up Exception Handling
     * @param string $id
     * @return array
     */
    public function get($id) : array
    {
        $record = $this->client->get([
            'index' => $this->index, 
            'id' => $id,
        ]);

        return $record;
    }

    /**
     * Update a document with $data
     *
     * @param array $data
     * @param string $id
     * @return array
     */
    public function update(array $data, $id)
    {
        $result = $this->client->update([
            'index' => $this->index,
            'id' => $id,
            'body' => [
                'doc' => $data,
            ]
        ]);

        return $result;
    }

    protected function parseQueryClauses(array $query) : array
    {
        $must = [];

        foreach ($query as $field => $value){
            if (is_array($value) && isset($value['range'])) {
                $must[]['range'][$field] = $value['range'];
            }
            elseif (is_array($value) ){
                $must[]['match'][$field] = $this->parseQueryClauses($value);
            }
            elseif (!empty($value)){
                $must[]['match'][$field] = $value;
            }
        }
        
        return $must;
    }

    public function search(array $query) : array
    {
        $search = [
            'index' => $this->index,
            'body'  => $this->parsePagination($query) + [
                'sort' => $this->parseSorting($query),
                'query' => [
                    'bool' => [
                        'must' => $this->parseQueryClauses($query)
                    ]
                ]
            ]
        ];

        $results = $this->client->search($search);

        return $results['hits'];
    }

    protected function parseSorting(&$query) : array
    {
        $sorting = isset($query['sort']) ? $query['sort'] : [];
        unset($query['sort']);

        return $sorting;
    }

    protected function parsePagination(&$query) : array
    {       
        $page = []; 
        if ( isset($query['pagination']) ){
            $page['from'] = (int) $query['pagination']['offset'] ?? null;
            $page['size'] = (int) $query['pagination']['limit'] ?? null;
        }

        unset($query['page'], $query['pagination'], $query['limit']);

        return $page;
    }

    public function searchExact(string $field, string $value)
    {
        $results = $this->client->search([
            'index' => $this->index,
            'body'  => [
                'query' => [
                    'term' => [
                        "{$field}.keyword" => [
                            'value' => $value
                        ]
                    ]
                ]
            ]
        ]);

        return $results['hits'];
    }
}