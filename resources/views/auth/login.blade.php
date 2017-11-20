@extends('layouts.app')

@section('content')
<div class="flex items-center">
    <div class="md:w-1/2 md:mx-auto">
        <div class="rounded shadow-lg">
            <div class="font-medium text-lg text-grey text-center bg-white p-3 pt-6 rounded rounded-t">
                Login
            </div>

            <div class="bg-white p-3 rounded rounded-b">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="flex items-stretch mb-3">
                        <div class="flex flex-col w-2/4 mx-auto">
                            <input id="email" placeholder="Email Address" type="email" class="flex-grow text-center border-off-white text-sm py-2 px-2 border rounded {{ $errors->has('email') ? 'border-red-dark' : 'border-grey-light' }}" name="email" value="{{ old('email') }}" required autofocus>
                            {!! $errors->first('email', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
                        </div>
                    </div>

                    <div class="flex items-stretch mb-4">
                        <div class="flex flex-col w-2/4 mx-auto">
                            <input id="password" placeholder="Password" type="password" class="flex-grow text-center border-off-white text-sm py-2 px-2 rounded border {{ $errors->has('password') ? 'border-red-dark' : 'border-grey-light' }}" name="password" required>
                            {!! $errors->first('password', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
                        </div>
                    </div>

                    <div class="flex">
                        <label class="w-full text-center mx-auto">
                            <input class="h-3 w-3" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="text-xs text-grey-dark"> Remember Me</span>
                        </label>
                    </div>

                    <div class="flex">
                        <div class="w-full text-center mx-auto">
                            <a class="inline-block mb-6 w-full no-underline hover:underline text-brand-dark text-xs" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>

                            <button type="submit" class="btn btn-primary mb-6">
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
