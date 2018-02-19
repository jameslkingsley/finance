<?php

namespace App\Models;

use App\Traits\HasTransactions;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasTransactions;

    /**
     * Guarded attributes.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'store',
        'completion',
        'amount_left',
    ];

    /**
     * Gets the store value.
     *
     * @return integer
     */
    public function getStoreAttribute()
    {
        return $this->deposit;
    }

    /**
     * Gets the amount left.
     *
     * @return integer|null
     */
    public function getAmountLeftAttribute()
    {
        if ($this->goal === null) {
            return null;
        }

        $deposited = $this->transactions()->get()->sum('amount');

        return $this->goal - $deposited;
    }

    /**
     * Gets the completion percentage.
     *
     * @return float
     */
    public function getCompletionAttribute()
    {
        $deposited = $this->transactions()->get()->sum('amount');
        $percentage = $deposited / $this->goal;

        return $percentage > 1 ? 1 : $percentage;
    }

    /**
     * Sets the goal field.
     *
     * @return void
     */
    public function setGoalAttribute($value)
    {
        $this->attributes['goal'] = $value * 100;
    }

    /**
     * Sets the deposit field.
     *
     * @return void
     */
    public function setDepositAttribute($value)
    {
        $this->attributes['deposit'] = $value * 100;
    }

    /**
     * Creats a transaction.
     *
     * @return \App\Models\Transaction
     */
    public function createTransaction(int $amount)
    {
        if (!$amount) {
            return;
        }

        return $this->transactions()->save(
            new Transaction([
                'amount' => $amount,
                'user_id' => auth()->user()->id,
            ])
        );
    }
}
