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
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        //

        try {
            $data = $product->toArray();
            $this->client->indexDocument(null, $data);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
        try {
            $data = $product->toArray();
            $this->client->updateDocument($product->id, $data);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
        try {
            $this->client->deleteDocument($product->id);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
