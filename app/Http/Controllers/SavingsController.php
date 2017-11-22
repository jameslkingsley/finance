<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavingsController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        auth()->user()->update([
            'savings' => $request->amount
        ]);
    }
}
