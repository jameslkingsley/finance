<?php

namespace App;

use App\WeekItem;
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
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(WeekItem::class);
    }
}
