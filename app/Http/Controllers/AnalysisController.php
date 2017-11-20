<?php

namespace App\Http\Controllers;

use App\Week;

class AnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weeks = Week::all()->transform(function ($week) {
            $week->total = $week->total();
            return $week;
        });

        return response()->json(compact('weeks'));
    }
}
