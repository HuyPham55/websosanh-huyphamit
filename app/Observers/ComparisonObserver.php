<?php

namespace App\Observers;

use App\Models\Comparison;
use App\Observers\ElasticContract\ElasticObserver;
use App\Services\ElasticService;

class ComparisonObserver extends ElasticObserver
{
    protected ElasticService $client;
    public function __construct()
    {
        $this->client = new ElasticService((new Comparison())->getTable());
        parent::__construct($this->client);
    }

    /**
     * Handle the Comparison "created" event.
     *
     * @param  \App\Models\Comparison  $comparison
     * @return void
     */
    public function created(Comparison $comparison)
    {
        //
        $this->addToIndex($comparison);
    }

    /**
     * Handle the Comparison "updated" event.
     *
     * @param  \App\Models\Comparison  $comparison
     * @return void
     */
    public function updated(Comparison $comparison)
    {
        //
        $this->updateDocument($comparison);
    }

    /**
     * Handle the Comparison "deleted" event.
     *
     * @param  \App\Models\Comparison  $comparison
     * @return void
     */
    public function deleted(Comparison $comparison)
    {
        //
        $this->client->deleteDocument($comparison->id);
    }

    /**
     * Handle the Comparison "restored" event.
     *
     * @param  \App\Models\Comparison  $comparison
     * @return void
     */
    public function restored(Comparison $comparison)
    {
        //
    }

    /**
     * Handle the Comparison "force deleted" event.
     *
     * @param  \App\Models\Comparison  $comparison
     * @return void
     */
    public function forceDeleted(Comparison $comparison)
    {
        //
    }


}
