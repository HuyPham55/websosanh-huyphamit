<?php

namespace App\Observers;

use App\Enums\CacheName;
use App\Models\BlogCategory;
use App\Services\NestedSetService;
use Illuminate\Support\Facades\Cache;

class BlogCategoryObserver
{
    /**
     * Handle the BlogCategory "created" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */
    public function created(BlogCategory $blogCategory)
    {
        //
        $this->doNestedCategories($blogCategory->getTable());
        $this->forgetCache();
    }

    /**
     * Handle the BlogCategory "updated" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */
    public function updated(BlogCategory $blogCategory)
    {
        //
        $this->doNestedCategories($blogCategory->getTable());
        $this->forgetCache();
    }

    /**
     * Handle the BlogCategory "deleted" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */
    public function deleted(BlogCategory $blogCategory)
    {
        //
        $this->doNestedCategories($blogCategory->getTable());
        $this->forgetCache();
    }

    /**
     * Handle the BlogCategory "restored" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */
    public function restored(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Handle the BlogCategory "force deleted" event.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return void
     */
    public function forceDeleted(BlogCategory $blogCategory)
    {
        //
    }
    private function forgetCache(): void
    {

    }

    private function doNestedCategories($tableName)
    {
        $nestedSet = new NestedSetService($tableName);
        $nestedSet->doNested();
    }
}
