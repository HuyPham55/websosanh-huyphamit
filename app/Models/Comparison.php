<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comparison extends BaseModel
{
    use HasFactory;

    public function products()
    {
        //A comparison is composed of many products
        return $this->belongsToMany(Product::class);
    }

    public function productCategory()
    {
        //Used for filter by product category
        return $this->belongsTo(ProductCategory::class);
    }
}
