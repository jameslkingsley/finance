<?php

namespace App\Traits;

use App\Models\Transaction;

trait HasTransactions
{
    /**
     * Gets the models transactions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'model');
    }
}
