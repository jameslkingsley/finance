<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
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

    /**
     * Gets all purchases for this month.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function thisMonth()
    {
        return auth()->user()->purchases()
            ->whereMonth('created_at', '=', now()->month)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
