<?php

namespace App\Http\Controllers;

use App\Week;
use App\WeekItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeekController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $week = Week::firstOrCreate([
            'user_id' => auth()->user()->id,
            'ending' => Carbon::parse($request->ending)
        ]);

        $week->items()->delete();

        foreach ($request->items as $item) {
            unset($item['total']);

            if (!$item['title'] || !$item['rate']) {
                continue;
            }

            $week->items()->save(
                new WeekItem($item)
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function show(Week $week)
    {
        return $week;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function edit(Week $week)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Week $week)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function destroy(Week $week)
    {
        //
    }
}
