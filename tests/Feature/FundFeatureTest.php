<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Fund;

class FundFeatureTest extends TestCase
{
    /** @test */
    public function can_create_a_fund()
    {
        $fund = auth()->user()->funds()->save(
            new Fund([
                'goal' => 2500,
                'name' => 'Phone',
                'frequency' => 'month',
            ])
        );

        $this->assertInstanceOf(Fund::class, $fund);

        return $fund;
    }
}
