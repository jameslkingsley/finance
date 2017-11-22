@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center">
        <span class="text-left uppercase font-semibold w-full text-sm mb-2 text-grey-lightest">
            This Month's Report
        </span>

        <div class="card mb-8">
            <f-summary></f-summary>
        </div>

        <f-week></f-week>
    </div>

    <div class="flex flex-wrap items-center">
        <span class="text-left uppercase font-semibold w-full text-sm mb-2 text-grey-lightest">
            Earnings Analysis
        </span>

        <div class="card w-full mb-8 md:p-4 p-0">
            <f-analysis></f-analysis>
        </div>
    </div>

    <div class="flex flex-wrap items-center">
        <div class="w-full md:w-auto md:flex-1 self-stretch md:mr-3 md:mb-0 mb-8">
            <f-expenses></f-expenses>
        </div>

        <div class="w-full md:w-auto md:flex-1 self-stretch md:ml-3">
            <f-purchases></f-purchases>
        </div>
    </div>
@endsection
