<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\ElasticService;

class ProductObserver
{
    protected ElasticService $client;

    public function __construct()
    {
        $this->client = new ElasticService((new Product())->getTable());
    }


    /**
     * Handle the Product "created" event.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function created(Product $product)
    {
        //

        try {
            $data = $product->toArray();
            $this->client->indexDocument(null, $data);
        } catch (\Exception $exception) {
            throw ($exception);
        }
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
        try {
            $data = $product->toArray();
            $exist = $this->client->getDocument($product->id);
            if ($exist === false) {
                $this->client->indexDocument(null, $data);
                return;
            }
            $this->client->updateDocument($product->id, $data);
        } catch (\Exception $exception) {
            throw ($exception);
        }
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
        $this->client->deleteDocument($product->id);
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
