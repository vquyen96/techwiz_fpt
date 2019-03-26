@extends('admin.layout')

@section('title', 'RMT Admin - Email')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/auth/reset_password.css') }}">
@endsection
@section('content')
<div class="container-fluid h-100 overflow-y bg-fixed-02">
    <div class="row flex-row h-100">
        <div class="col-12 my-auto">
            <div class="password-form mx-auto">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="logo-centered">
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="logo">
                    </a>
                </div>
                <h3>{{ __('locale/auth/password/email.password_recovery') }}</h3>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="group material-input">
                        <input type="email" name="email" required value="{{ app('request')->input('email') }}">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>{{ app('request')->input('email') == null ? '' : __('local/auth/password/email.email') }}</label>
                    </div>
                    <div class="button text-center">
                        <button type="submit" class="btn btn-lg btn-gradient-01 d-flex align-items-center m-auto" {{ app('request')->input('email') ? 'disabled' : '' }}>
                            @if(app('request')->input('email'))
                                <div id="countdown">
                                    <div id="countdown-number"></div>
                                    <svg>
                                        <circle r="18" cx="20" cy="20"></circle>
                                    </svg>
                                </div>
                                <div>{{ __('locale/auth/password/email.send_again') }}</div>
                            @else
                                {{ __('locale/auth/password/email.send_mail') }}
                            @endif
                        </button>
                    </div>
                </form>
                <div class="back d-flex justify-content-between">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-secondary">
                            @if( \Session::get('website_language', config('app.locale')) === 'en')
                                <img src="{{ asset('assets/img/flag/en.svg') }}" alt="" width="20px">
                            @else
                                <img src="{{ asset('assets/img/flag/ja.svg') }}" alt="" width="20px">
                            @endif
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{  \Session::get('website_language', config('app.locale')) === 'en' ? 'English' : '日本語' }}
                        </button>
                        <div class="dropdown-menu">
                            @if( \Session::get('website_language', config('app.locale')) === 'en')
                                <a class="dropdown-item" href="{{ route('admin.change-language', ['ja']) }}">日本語</a>
                            @else
                                <a class="dropdown-item" href="{{ route('admin.change-language', ['en']) }}">English</a>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-lg btn-gradient-03">
                        {{ __('locale/auth/password/email.sign_in') }}
                    </a>
                </div>
            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Row -->
</div>
@endsection

@section('script')
<script>
    var countdownNumberEl = document.getElementById('countdown-number');
    var countdown = 30;
    countdownNumberEl.textContent = countdown;
    var interval = setInterval(function() {
        --countdown
        if (countdown <= 0) {
            $('#countdown').hide();
            $('button[type="submit"]').prop('disabled', false);
            clearInterval(interval)
        }
        countdownNumberEl.textContent = countdown;
    }, 1000);
</script>
@endsection


