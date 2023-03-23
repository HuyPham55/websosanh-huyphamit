<?php

namespace App\Rules;

use App\Models\Scrape;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Crypt;

class ValidateUniqueEncrypted implements Rule
{
    protected string $field;
    protected mixed $model;
    protected int $except;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model, $field, $except = 0)
    {
        //
        $this->model = $model;
        $this->field = $field;
        $this->except = $except;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $collection = $this->model::all();
        foreach ($collection as $item) {
            if (($value == $item->{$this->field}) && ($item->id != $this->except)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.unique');
    }
}
