@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center">
        <div class="card mb-6">
            <f-summary></f-summary>
        </div>

        <div class="card mb-6">
            <f-week></f-week>
        </div>

        {{-- <div class="card">
            List of expenses with form to enter new data
        </div> --}}
    </div>
@endsection
