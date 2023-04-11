<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $created_at
 */
class Contact extends Model
{
    use HasFactory;
    use Filterable;

    protected $guarded = [];
    public function getDateFormatAttribute()
    {
        if ($this->created_at) {
            return date_format($this->created_at, 'Y/m/d');
        }
    }

}
