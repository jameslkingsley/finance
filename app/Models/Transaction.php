<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * Guarded attributes.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Sets the amount field.
     *
     * @return void
     */
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value * 100;
    }
}
