@extends('layouts.app')

@section('content')
    <grid auto-rows="min-content" doubles gap="2rem">
        <f-summary></f-summary>
        <f-income></f-income>

        <f-funds></f-funds>
        <f-purchases></f-purchases>

        <grid-child column-start="1" column-end="3">
            <f-analysis></f-analysis>
        </grid-child>
    </grid>
@endsection
