@extends('layouts.app')

@section('content')
<div class="flex items-center">
    <div class="md:w-1/2 md:mx-auto">
        <div class="rounded shadow-lg">
            <div class="font-medium text-lg text-grey text-center bg-white p-3 pt-6 rounded rounded-t">
                Register
            </div>

            <div class="bg-white p-3 rounded rounded-b">
                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="flex items-stretch mb-3">
                        <div class="flex flex-col w-2/4 mx-auto">
                            <input id="email" placeholder="Full Name" class="flex-grow text-center border-off-white text-sm py-2 px-2 border rounded {{ $errors->has('name') ? 'border-red-dark' : 'border-grey-light' }}" name="name" value="{{ old('name') }}" autofocus>
                            {!! $errors->first('name', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
                        </div>
                    </div>

                    <div class="flex items-stretch mb-3">
                        <div class="flex flex-col w-2/4 mx-auto">
                            <input id="email" type="email" placeholder="Email Address" class="flex-grow text-center border-off-white text-sm py-2 px-2 border rounded {{ $errors->has('email') ? 'border-red-dark' : 'border-grey-light' }}" name="email" value="{{ old('email') }}" required>
                            {!! $errors->first('email', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
                        </div>
                    </div>

                    <div class="flex items-stretch mb-4">
                        <div class="flex flex-col w-2/4 mx-auto">
                            <input id="password" placeholder="Password" type="password" class="flex-grow text-center border-off-white text-sm py-2 px-2 border rounded {{ $errors->has('password') ? 'border-red-dark' : 'border-grey-light' }}" name="password" required>
                            {!! $errors->first('password', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
                        </div>
                    </div>

                    <div class="flex items-stretch mb-4">
                        <div class="flex flex-col w-2/4 mx-auto">
                            <input id="password_confirmation" placeholder="Confirm Password" type="password" class="flex-grow text-center border-off-white text-sm py-2 px-2 border rounded {{ $errors->has('password_confirmation') ? 'border-red-dark' : 'border-grey-light' }}" name="password_confirmation" required>
                            {!! $errors->first('password_confirmation', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-full text-center mx-auto">
                            <button type="submit" class="btn btn-primary mb-6">
                                Register
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
