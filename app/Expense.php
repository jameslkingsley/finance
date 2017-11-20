<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
     * Guarded attributes.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Casted attributes.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'float'
    ];
}
