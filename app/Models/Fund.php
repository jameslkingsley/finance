<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
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
        'per_week',
        'per_year',
        'per_month',
    ];

    /**
     * The frequency divisors.
     *
     * @var array
     */
    protected $frequencyDivisors = [
        'week' => 1,
        'month' => 4,
        'year' => 52
    ];

    /**
     * Gets the amount needed per week.
     *
     * @return integer
     */
    public function getPerWeekAttribute()
    {
        return $this->goal / $this->frequencyDivisors['week'];
    }

    /**
     * Gets the amount needed per month.
     *
     * @return integer
     */
    public function getPerMonthAttribute()
    {
        return $this->goal / $this->frequencyDivisors['month'];
    }

    /**
     * Gets the amount needed per year.
     *
     * @return integer
     */
    public function getPerYearAttribute()
    {
        return $this->goal / $this->frequencyDivisors['year'];
    }

    /**
     * Moves this fund's given amount to the given fund.
     *
     * @return \App\Models\Adjustment // TODO
     */
    public function move(Fund $fund, int $amount)
    {
        // Create and return adjustment record
    }

    /**
     * Transfer the given amount into the fund.
     *
     * @return \App\Models\Fund
     */
    public function in(int $amount)
    {
        // Create transaction

        return $this;
    }

    /**
     * Transfer the given amount out of the fund.
     *
     * @return \App\Models\Fund
     */
    public function out(int $amount)
    {
        // Create transaction

        return $this;
    }
}
