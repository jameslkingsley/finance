<?php

namespace App;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use BelongsToUser;

    /**
     * Guarded attributes.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relationships to include.
     *
     * @var array
     */
    protected $with = [
        'items'
    ];

    /**
     * Gets the week items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(WeekItem::class);
    }

    /**
     * Gets the week total.
     *
     * @return integer
     */
    public function total()
    {
        return $this->items->sum('total');
    }

    /**
     * Gets the given month income.
     *
     * @return integer
     */
    public static function income()
    {
        $income = 0;

        static::whereMonth('ending', '=', now()->month)->get()
            ->each(function ($week) use (&$income) {
                $income += $week->total();
            });

        return $income;
    }
}
