<?php

namespace App\Observers;

use App\Models\ProductCategory;
use App\Services\NestedSetService;

class ProductCategoryObserver
{
    /**
     * Handle the ProductCategory "created" event.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return void
     */
    public function created(ProductCategory $productCategory)
    {
        //
        $this->doNestedCategories($productCategory->getTable());
    }

    /**
     * Handle the ProductCategory "updated" event.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return void
     */
    public function updated(ProductCategory $productCategory)
    {
        //
        $this->doNestedCategories($productCategory->getTable());
    }

    /**
     * Handle the ProductCategory "deleted" event.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return void
     */
    public function deleted(ProductCategory $productCategory)
    {
        //
        $this->doNestedCategories($productCategory->getTable());
        $productCategory->sellers()->detach();
    }

    /**
     * Handle the ProductCategory "restored" event.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return void
     */
    public function restored(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Handle the ProductCategory "force deleted" event.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return void
     */
    public function forceDeleted(ProductCategory $productCategory)
    {
        //
    }
    private function doNestedCategories($tableName)
    {
        $nestedSet = new NestedSetService($tableName);
        $nestedSet->doNested();
    }

}
