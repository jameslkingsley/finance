<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Fund;

class FundFeatureTest extends TestCase
{
    /** @test */
    public function can_create_a_fund($name = 'Fund')
    {
        $fund = auth()->user()->funds()->save(
            new Fund([
                'goal' => 2500,
                'name' => $name,
                'frequency' => 'month',
            ])
        );

        $this->assertInstanceOf(Fund::class, $fund);

        return $fund;
    }

    /** @test */
    public function can_move_a_fund()
    {
        $fundA = $this->can_create_a_fund('Fund A');
        $fundB = $this->can_create_a_fund('Fund B');

        $fundA->move(1000, $fundB);

        $this->assertTrue();
    }
}
