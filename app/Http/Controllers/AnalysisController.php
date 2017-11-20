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

        return response()->json(compact('weeks'));
    }
}
