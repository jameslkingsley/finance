<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserBornController extends Controller
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
        $attributes = $request->validate([
            'born' => 'required'
        ]);

        auth()->user()->update($attributes);
    }
}
