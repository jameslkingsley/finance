@extends('layouts.app')

@section('content')
    <grid auto-rows="min-content" doubles gap="2rem">
        {{-- <grid-child column-start="1" column-end="3"> --}}
            <f-summary></f-summary>
            <f-income></f-income>
        {{-- </grid-child> --}}

        {{-- <grid-child column-start="1" column-end="3"> --}}
        {{-- </grid-child> --}}

        <f-funds></f-funds>
        <f-savings></f-savings>

        <grid-child column-start="1" column-end="3">
            <f-week></f-week>
        </grid-child>

        <grid-child column-start="1" column-end="3">
            <f-analysis></f-analysis>
        </grid-child>

        <f-expenses></f-expenses>
        <f-purchases></f-purchases>
    </grid>
@endsection
