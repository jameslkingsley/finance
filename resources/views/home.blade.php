@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center">
        <span class="text-left uppercase font-semibold w-full text-sm mb-2 text-grey-lightest">
            This Month's Report
        </span>

        <div class="card mb-8">
            <f-summary></f-summary>
        </div>

        <span class="text-left uppercase font-semibold w-full text-sm mb-2 text-grey-lightest">
            This Week's Work
        </span>

        <div class="card mb-8">
            <f-week></f-week>
        </div>
    </div>

    <div class="flex flex-wrap items-center">
        <span class="text-left uppercase font-semibold w-full text-sm mb-2 text-grey-lightest">
            Earnings Analysis
        </span>

        <div class="card w-full mb-8">
            <f-analysis></f-analysis>
        </div>
    </div>

    <div class="flex flex-wrap items-center">
        <div class="flex-1 self-stretch mr-3">
            <span class="text-left uppercase font-semibold w-full text-sm text-grey-lightest">
                Monthly Expenses
            </span>

            <div class="card w-full mt-2">
                <f-expenses></f-expenses>
            </div>
        </div>

        <div class="flex-1 self-stretch ml-3">
            <span class="text-left uppercase font-semibold w-full text-sm text-grey-lightest">
                This Month's Purchases
            </span>

            <div class="card w-full mt-2">
                <f-purchases></f-purchases>
            </div>
        </div>
    </div>
@endsection
