<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoalController extends Controller
{
    /**
     * Constructor method.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return tap(auth()->user())->update([
            'goal' => $request->amount * 100
        ])->goal;
    }
}
