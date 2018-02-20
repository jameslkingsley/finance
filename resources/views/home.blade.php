@extends('layouts.app')

@section('content')
    <grid auto-rows="min-content" doubles gap="2rem">
        <grid auto-rows="min-content" singles gap="2rem">
            <f-summary></f-summary>
            <f-funds></f-funds>
        </grid>

        <grid auto-rows="min-content" singles gap="2rem">
            <f-income></f-income>
            <f-purchases></f-purchases>
        </grid>
    </grid>
@endsection
