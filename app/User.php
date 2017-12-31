<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Guarded attributes.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Casts.
     *
     * @var array
     */
    protected $casts = [
        'goal' => 'float',
        'savings' => 'float'
    ];

    /**
     * Gets the users expenses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Gets the users purchases.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Gets the users weeks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function weeks()
    {
        return $this->hasMany(Week::class);
    }

    /**
     * Gets the average rate of the user.
     *
     * @return integer
     */
    public function averageRate()
    {
        $rates = collect();

        foreach ($this->weeks as $week) {
            foreach ($week->items as $item) {
                $rates->push($item->rate);
            }
        }

        return $rates->average();
    }
}
