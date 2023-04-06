<?php

namespace App\Observers\ElasticContract;

use App\Services\ElasticService;
use Illuminate\Database\Eloquent\Model;

class ElasticObserver
{
    protected ElasticService $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    protected function addToIndex(Model $item)
    {
        try {
            $data = $item->toArray();
            $this->client->indexDocument(null, $data);
        } catch (\Exception $exception) {
            throw ($exception);
        }
    }

    protected function updateDocument(Model $item, bool $createIfNotExist = true)
    {
        try {
            $data = $item->toArray();
            $exist = $this->client->getDocument($item->id | 0);
            if ($exist === false && $createIfNotExist) {
                $this->client->indexDocument(null, $data, $item->id);
                return;
            }
            $this->client->updateDocument($item->id, $data);
        } catch (\Exception $exception) {
            throw ($exception);
        }
    }

}
