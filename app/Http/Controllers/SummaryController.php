<?php

namespace App\Http\Controllers;

use App\Purchase;

class SummaryController extends Controller
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

        return response()->json(compact('income', 'transactions', 'purchases'));
    }
}
