<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\HasTransactions;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasTransactions;

    /**
     * Guarded attributes.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Date attributes.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'bills_on'
    ];

    /**
     * Appended attributes.
     *
     * @var array
     */
    protected $appends = [
        'deposit',
        'per_week',
        'this_week',
        'days_left',
        'amount_left',
        'completion',
        'frequency_full',
        'bills_on_next'
    ];

    /**
     * Attribute casts.
     *
     * @var array
     */
    protected $casts = [
        'savings' => 'boolean'
    ];

    /**
     * Gets the deposit value.
     *
     * @return integer
     */
    public function getDepositAttribute()
    {
        return $this->this_week;
    }

    /**
     * Gets the transactions for the frequency period.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function periodTransactions()
    {
        $transactions = $this->transactions();

        if ($this->frequency === 'week') {
            $transactions = $transactions->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]);
        }

        if ($this->frequency === 'month') {
            $transactions = $transactions->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ]);
        }

        if ($this->frequency === 'year') {
            $transactions = $transactions->whereBetween('created_at', [
                now()->startOfYear(),
                now()->endOfYear()
            ]);
        }

        return $transactions->get();
    }

    /**
     * Gets the completion percentage.
     *
     * @return float
     */
    public function getCompletionAttribute()
    {
        $deposited = $this->periodTransactions()->sum('amount');
        $percentage = $deposited / $this->goal;

        return $percentage > 1 ? 1 : $percentage;
    }

    /**
     * Sets the goal amount field.
     *
     * @return void
     */
    public function setGoalAttribute($value)
    {
        $this->attributes['goal'] = $value * 100;
    }

    /**
     * Sets the fixed amount field.
     *
     * @return void
     */
    public function setFixedAttribute($value)
    {
        $this->attributes['fixed'] = $value * 100;
    }

    /**
     * Gets the next date of the bill.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getBillsOnNextAttribute()
    {
        if (now()->lte($this->bills_on)) {
            return $this->bills_on->toDateTimeString();
        }

        if ($this->frequency === 'week') {
            return $this->bills_on->next()->toDateTimeString();
        }

        if ($this->frequency === 'month') {
            return Carbon::create(
                now()->year,
                now()->addMonth()->month,
                $this->bills_on->day
            )->toDateTimeString();
        }

        if ($this->frequency === 'year') {
            return Carbon::create(
                now()->addYear()->year,
                $this->bills_on->month,
                $this->bills_on->day
            )->toDateTimeString();
        }
    }

    /**
     * Gets the full frequency text.
     *
     * @return string
     */
    public function getFrequencyFullAttribute()
    {
        return title_case($this->frequency) . 'ly';
    }

    /**
     * Gets the amount needed per week.
     *
     * @return integer
     */
    public function getPerWeekAttribute()
    {
        if (!is_null($this->fixed)) {
            return $this->fixed;
        }

        if ($this->frequency === 'month') {
            return ($this->goal * 12) / 52;
        }

        if ($this->frequency === 'year') {
            return $this->goal / 52;
        }

        return $this->goal;
    }

    /**
     * Gets the days left to next bill.
     *
     * @return integer
     */
    public function getDaysLeftAttribute()
    {
        return now()->diffInDays(Carbon::parse($this->bills_on_next));
    }

    /**
     * Gets the weeks left to next bill.
     *
     * @return integer
     */
    public function weeksLeft()
    {
        return now()->diffInWeeks(Carbon::parse($this->bills_on_next));
    }

    /**
     * Gets the amount needed this week.
     *
     * @return integer
     */
    public function getThisWeekAttribute()
    {
        if (!is_null($this->fixed)) {
            return $this->fixed;
        }

        $amountLeft = $this->amount_left;
        $weeksLeft = $this->weeksLeft();

        if ($weeksLeft <= 0) {
            return $amountLeft;
        }

        if ($amountLeft <= 0) {
            return 0;
        }

        if ($amountLeft <= $this->per_week) {
            return $amountLeft;
        }

        if (($amountLeft / $weeksLeft) <= $this->per_week) {
            return $this->per_week;
        }

        return min($this->per_week, $amountLeft / $weeksLeft);
    }

    /**
     * Gets the amount left this period.
     *
     * @return integer
     */
    public function getAmountLeftAttribute()
    {
        return $this->goal - $this->periodTransactions()->sum('amount');
    }

    /**
     * Moves this fund's given amount to the given fund.
     *
     * @return \App\Models\Adjustment
     */
    public function move(int $amount, Fund $fund)
    {
        // Transfer from this fund
        auth()->user()->adjustments()->save(
            new Adjustment([
                'amount' => -$amount,
                'fund_id' => $this->id,
            ])
        );

        // To this fund
        return auth()->user()->adjustments()->save(
            new Adjustment([
                'amount' => $amount,
                'fund_id' => $fund->id,
            ])
        );
    }

    /**
     * Transfer the given amount into the fund.
     *
     * @return \App\Models\Fund
     */
    public function in(int $amount)
    {
        auth()->user()->transactions()->save(
            new Transaction([
                'amount' => $amount,
                'fund_id' => $this->id,
            ])
        );

        return $this;
    }

    /**
     * Transfer the given amount out of the fund.
     *
     * @return \App\Models\Fund
     */
    public function out(int $amount)
    {
        auth()->user()->transactions()->save(
            new Transaction([
                'amount' => -$amount,
                'fund_id' => $this->id,
            ])
        );

        return $this;
    }

    /**
     * Creats a transaction.
     *
     * @return \App\Models\Transaction
     */
    public function createTransaction($amount)
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
