@extends('admin.layout')

@section('title', 'AMZ - Login')

@section('content')

    <div class="container-fluid no-padding h-100">
        <div class="row flex-row h-100 bg-white">
            <div class="col-xl-8 col-lg-6 col-md-5 no-padding">
                <div class="elisyam-bg background-01">
                    <div class="elisyam-overlay overlay-01"></div>
                    <div class="authentication-col-content mx-auto">
                        <h1 class="gradient-text-01">{{ __('locale/auth/login.welcome') }}</h1>
                        <span class="description"></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-7 my-auto no-padding">
                <div class="authentication-form mx-auto">
                    <div class="logo-centered">
                        <a href="#"><img src="{{ asset('public/assets/img/logo.png') }}" alt="logo"></a>
                    </div>
                    <h3>{{ __('locale/auth/login.signin') }}</h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="group material-input">
                            <input id="email_input" type="text" name="email" value="{{ old('email') }}" required autofocus>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="email_input">{{ __('locale/auth/login.email') }}</label>
                        </div>
                        <div class="group material-input">
                            <input id="password_input" type="password" name="password" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="password_input">{{ __('locale/auth/login.password') }}</label>
                        </div>
                        <div class="row">
                            <div class="col text-left">
                                <div class="styled-checkbox">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">{{ __('locale/auth/login.remember_me') }}</label>
                                </div>
                            </div>
                            <div class="col text-right">
                                <a href="{{route('password.request')}}">{{ __('locale/auth/login.forgot_password') }}</a>
                            </div>
                        </div>
                        <div class="sign-btn text-center d-flex justify-content-between">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary">
                                    @if( \Session::get('website_language', config('app.locale')) === 'en')
                                        <img src="{{ asset('public/assets/img/flag/en.svg') }}" alt="" width="20px">
                                    @else
                                        <img src="{{ asset('public/assets/img/flag/ja.svg') }}" alt="" width="20px">
                                    @endif
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{  \Session::get('website_language', config('app.locale')) === 'en' ? 'English' : '日本語' }}
                                </button>
                                {{--<div class="dropdown-menu">--}}
                                    {{--@if( \Session::get('website_language', config('app.locale')) === 'en')--}}
                                        {{--<a class="dropdown-item" href="{{ route('admin.change-language', ['ja']) }}">日本語</a>--}}
                                    {{--@else--}}
                                        {{--<a class="dropdown-item" href="{{ route('admin.change-language', ['en']) }}">English</a>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            </div>
                            <button type="submit" class="btn btn-lg btn-gradient-01">{{ __('locale/auth/login.signin') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    @if( !$errors->isEmpty() )
        <script type="application/javascript">
            (function ($) {
                'use strict';

                @foreach ( $errors->all() as $errorMessage )
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: '{{ $errorMessage }}',
                        progressBar: true,
                        timeout: 5000,
                        animation: {
                            open: 'animated bounceInRight',
                            close: 'animated bounceOutRight'
                        }
                    }).show();
                @endforeach
            })(jQuery);
        </script>
    @endif

@endsection
