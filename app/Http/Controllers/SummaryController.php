<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $income = auth()->user()->incomes()
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])->get()->sum('amount');

        $transactions = auth()->user()->transactions()
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])->get()->sum('amount');

        $purchases = Purchase::thisMonth()->sum('amount');
        $goal = auth()->user()->goal;
        $savings = auth()->user()->savings;
        $averageWeeklyIncome = auth()->user()->weeks->average(function ($week) {
            return $week->total();
        });

        $born = auth()->user()->born;
        $averageRate = auth()->user()->averageRate();

        return response()->json(compact('income', 'transactions', 'goal', 'averageWeeklyIncome', 'purchases', 'savings', 'born', 'averageRate'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
