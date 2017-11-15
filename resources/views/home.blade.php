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

        <div class="card mb-6">
            <f-week></f-week>
        </div>

        {{-- <div class="card">
            List of expenses with form to enter new data
        </div> --}}
    </div>
@endsection
