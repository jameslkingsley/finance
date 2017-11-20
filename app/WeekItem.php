<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeekItem extends Model
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
    protected $appends = ['total'];

    /**
     * Gets the total.
     *
     * @return integer
     */
    public function getTotalAttribute()
    {
        $total = 0;

        foreach (['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'] as $day) {
            $total += $this->rate * $this->{$day};
        }

        return $total;
    }
}
