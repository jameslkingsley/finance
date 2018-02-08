@extends('layouts.app-lite')

@section('content')
    <grid template-rows="64px 1fr" class="container mx-auto h-screen overflow-hidden">
        <nav class="h-full md:px-0 px-6">
            <div class="container mx-auto h-full">
                <div class="flex items-center justify-center h-16">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="no-underline font-semibold">
                            <img class="float-left mt-1 mr-2 w-4 h-4" src="{{ url('/images/logo.png') }}"> {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <div class="flex-1 text-right">
                        @guest
                            <a class="no-underline hover:underline text-grey-darker pr-3 text-sm font-semibold" href="{{ url('/login') }}">Login</a>
                            <a class="no-underline hover:underline text-grey-darker text-sm font-semibold" href="{{ url('/register') }}">Register</a>
                        @else
                            <span class="text-grey-darker text-sm pr-4 font-semibold">{{ Auth::user()->name }}</span>

                            <a href="{{ route('logout') }}"
                                class="no-underline hover:underline text-grey-darker text-sm font-semibold"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <grid>
            <span class="text-center text-4xl font-thin pt-12">Finance tracking for shopaholics.</span>
            <span class="text-center text-xl font-thin pt-1 pb-1 opacity-75">Track savings, expenses, purchases and wages.</span>
            <span class="text-center pt-8">
                <a href="{{ url('/register') }}" class="btn btn-lg btn-flat btn-primary">Get Started</a>
            </span>

            <mobile class="mx-auto mt-12" shadow>
                <bg-image size="190%" position="top center" url="{{ url('/images/app.png') }}"></bg-image>
            </mobile>
        </grid>
    </grid>
@endsection
