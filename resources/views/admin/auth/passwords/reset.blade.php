@extends('admin.layout')

@section('title', 'RMT Admin - Reset password')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/auth/reset_password.css') }}">
@endsection
@section('content')
<div class="container-fluid h-100 overflow-y bg-fixed-02">
    <div class="row flex-row h-100">
        <div class="col-12 my-auto">
            <div class="card">
                <div class="card-header">{{ __('locale/auth/password/reset.reset_password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('locale/auth/password/reset.email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('locale/auth/password/reset.password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('locale/auth/password/reset.password_confirm') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-4 d-flex justify-content-end">
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
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('locale/auth/password/reset.reset_password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
