<?php

namespace App\Services;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticService
{
    protected array $hosts;
    protected Client $client;
    private string $index;

    public function __construct($index)
    {
        $connectionString = env("ELASTIC_HOST", "localhost") . ':' . env("ELASTIC_PORT", '9200');
        $this->hosts = [
            $connectionString
        ];
        $this->client = ClientBuilder::create()
            ->setHosts($this->hosts)
            ->build();
        $this->index = $index;
        return $this->client;
    }

    public function clientIndo()
    {
        return $this->client->info();
    }

    public function clusterHealth()
    {
        return $this->client->cluster()->health();
    }

    public function indexExist($index = null)
    {
        if ($index == null) {
            $index = $this->index;
        }
        $params = [
            'index' => $index,
        ];
        return $this->client->indices()->exists($params);
    }

    public function createIndex($index = null)
    {
        if ($index == null) {
            $index = $this->index;
        }
        $params = ['index' => $index];

        return $this->client->indices()->create($params);
    }

    public function deleteIndex($index = null)
    {
        if ($index == null) {
            $index = $this->index;
        }
        if ($this->indexExist($index)) {
            $this->client->indices()->delete(['index' => $index]);
        }
    }

    public function indexDocument($index, array $document, $document_id = null, $type = null)
    {
        $params = [
            'index' => $this->index,
            'id' => $document_id,
            'type' => $type,
            'body' => $document
        ];
        return $this->client->index($params);
    }

    public function getDocument($document_id)
    {
        return $this->client->get([
            'index' => $this->index,
            'id' => $document_id,
        ]);
    }

    public function batchIndex($array)
    {
        $params = [];
        foreach ($array as $item) {
            $params['body'][] = [
                'index' => [
                    '_index' => $this->index,
                    '_id' => $item['id'] ?? null,
                ]
            ];

            $params['body'][] = $item;
        }
        return $this->client->bulk($params);
    }


    public function bulkIndex($array, $limit)
    {
        $params = [];

        for ($i = 0; $i < count($array); $i++) {
            $item = $array[$i];
            $params[] = $item;
            if ($i % $limit == 0) {
                $responses = $this->batchIndex($params);
                $params = [];
                unset($responses);
            }
        }
        if (!empty($params)) {
            $this->batchIndex($params);
        }
    }

    public function updateDocument($id, array $data)
    {
        $params = [
            'index' => $this->index,
            'id' => $id,
            'body' => [
                'doc' => $data
            ]
        ];
        return $this->client->update($params);
    }


    public function deleteDocument($id)
    {
        $params = [
            'index' => $this->index,
            'id' => $id
        ];
        return $this->client->delete($params);
    }
}
