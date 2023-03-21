<?php

namespace App\Observers;

use App\Models\Scrape;

class ScrapeObserver
{
    /**
     * Handle the Scrape "created" event.
     *
     * @param  \App\Models\Scrape  $scrape
     * @return void
     */
    public function created(Scrape $scrape)
    {
        //
    }

    /**
     * Handle the Scrape "updated" event.
     *
     * @param  \App\Models\Scrape  $scrape
     * @return void
     */
    public function updated(Scrape $scrape)
    {
        //
    }

    /**
     * Handle the Scrape "deleted" event.
     *
     * @param  \App\Models\Scrape  $scrape
     * @return void
     */
    public function deleted(Scrape $scrape)
    {
        //
        foreach ($scrape->products()->get() as $product) {
            $product->delete();
        }
    }

    /**
     * Handle the Scrape "restored" event.
     *
     * @param  \App\Models\Scrape  $scrape
     * @return void
     */
    public function restored(Scrape $scrape)
    {
        //
    }

    /**
     * Handle the Scrape "force deleted" event.
     *
     * @param  \App\Models\Scrape  $scrape
     * @return void
     */
    public function forceDeleted(Scrape $scrape)
    {
        //
    }
}
