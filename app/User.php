<?php

namespace App;

use App\Models\Fund;
use App\Models\Income;
use App\Models\Adjustment;
use App\Models\Transaction;
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
        //
    ];

    /**
     * Gets the users funds.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function funds()
    {
        return $this->hasMany(Fund::class);
    }

    /**
     * Gets the users adjustments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adjustments()
    {
        return $this->hasMany(Adjustment::class);
    }

    /**
     * Gets the users transactions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Gets the users incomes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

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
