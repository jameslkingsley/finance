<?php

namespace App\Http\Controllers;

class AnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weeks = auth()->user()->weeks->transform(function ($week) {
            $week->total = $week->total();
            return $week;
        });

        $purchases = auth()->user()->purchases->groupBy(function ($purchase) {
            return (string) $purchase->created_at->weekOfYear;
        })->transform(function ($group) {
            return $group->sum('amount');
        });

        return response()->json(compact('weeks', 'purchases'));
    }
}
