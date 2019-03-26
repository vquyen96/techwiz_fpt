<header class="header">
    <nav class="navbar fixed-top">
        <div class="search-box">
            <button class="dismiss"><i class="ion-close-round"></i></button>
            <form id="searchForm" action="#" role="search">
                <input type="search" placeholder="Search something ..." class="form-control">
            </form>
        </div>
        <div class="navbar-holder d-flex align-items-center align-middle justify-content-between">
            <div class="navbar-header">
                <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                    <div class="brand-image brand-big">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="logo-big">
                    </div>
                    <div class="brand-image brand-small">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="logo-small">
                    </div>
                </a>
                <a id="toggle-btn" href="#" class="menu-btn active">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            </div>
            <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center pull-right">
                {{--<li class="nav-item d-flex align-items-center">--}}
                    {{--<a id="search" href="#"><i class="la la-search"></i></a>--}}
                {{--</li>--}}
                <li class="nav-item d-flex align-items-center">
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
                </li>

                <li class="nav-item dropdown">
                    <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">
                        <i class="la la-bell {{ $countNoti > 0 ? 'animated infinite swing' : '' }} "></i>
                        @if($countNoti > 0)
                            <span class="badge-pulse"></span>
                        @endif
                    </a>
                    <ul aria-labelledby="notifications" class="dropdown-menu notification overflow-auto">
                        <li>
                            <div class="notifications-header">
                                <div class="title">{{ __('locale/widgets/header.notifications') }} ({{ $countNoti }})</div>
                                <div class="notifications-overlay"></div>
                                <img src="{{ asset('assets/img/notifications/01.jpg') }}" alt="..." class="img-fluid">
                            </div>
                        </li>

                        @foreach($notiAdmin as $noti)
                            <li class="{{ $noti->status == App\Enums\Notifications\Status::CREATE ? 'unread' : '' }}">
                                <a href="{{ asset('admin/'.$noti->path) }}">
                                    <div class="message-icon">
                                        @if($noti->image_url)
                                            <img src="{{ $noti->image_url }}"
                                                 style="width: 50px;" class="img-fluid">
                                        @else
                                            <img src="{{ asset('assets/img/default-image.png') }}"
                                                 style="width: 50px;" class="img-fluid">
                                        @endif
                                    </div>
                                    <div class="message-body">
                                        <div class="message-body-heading">
                                            @notificationTitle(['noti' => $noti])
                                            @endnotificationTitle
                                        </div>
                                        <div class="message-body-main">
                                            @notificationContent(['noti' => $noti])
                                            @endnotificationContent
                                        </div>
                                        <span class="date">{{ Carbon\Carbon::parse($noti->created_at)->diffForHumans() }}</span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a rel="nofollow" href="{{ route('admin.notification.index') }}" class="dropdown-item all-notifications text-center">{{ __('locale/widgets/header.notifications_all') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="user" rel="nofollow" data-target="#" href="#" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" class="nav-link">
                        @if(Auth::guard('admin')->user()->avatar_url)
                            <img src="{{ Auth::guard('admin')->user()->avatar_url }}" alt="..." class="avatar rounded-circle">
                        @else
                            <img src="{{ asset('assets/img/default-user.png') }}" alt="..." class="avatar rounded-circle">
                        @endif
                    </a>
                    <ul aria-labelledby="user" class="user-size dropdown-menu pb-4">
                        <li class="welcome">
                            @if(Auth::guard('admin')->user()->avatar_url)
                                <img src="{{ Auth::guard('admin')->user()->avatar_url }}" alt="..." class="rounded-circle">
                            @else
                                <img src="{{ asset('assets/img/default-user.png') }}" alt="..." class="rounded-circle">
                            @endif
                        </li>
                        <li class="text-center">
                            {{ __('locale/widgets/header.welcome') }},
                            {{
                                $userName = Auth::guard('admin')->user()->name ?
                                Auth::guard('admin')->user()->name : Auth::guard('admin')->user()->email,
                                (strlen($userName) > 50) ? substr($userName, 0, 50).' ...' : $userName
                            }} !
                        </li>
                        <li class="separator"></li>
                        <li><a href="{{ route('admin.profile.edit') }}" class="dropdown-item">{{ __('locale/widgets/header.profile') }}</a></li>
                            <li><a href="#" class="dropdown-item">{{ __('locale/widgets/header.messages') }}</a></li>
                        <li><a href="#" class="dropdown-item no-padding-bottom" data-toggle="modal" data-target="#change-password-modal">{{ __('locale/widgets/header.change_password') }}</a></li>
                        <li class="separator"></li>
                        <li><a href="#" class="dropdown-item no-padding-bottom" data-toggle="modal" data-target="#logout-modal">{{ __('locale/widgets/header.logout') }}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<form action="{{ route('logout') }}" method="POST">
    @csrf

    <div id="logout-modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="section-title mt-5 mb-5">
                        <h2 class="text-gradient-02">{{ __('locale/widgets/header.logout_messages') }}</h2>
                    </div>
                    <button type="button" class="btn btn-secondary mb-3 mr-3" data-dismiss="modal">
                        <i class="la la-close"></i>{{ __('locale/widgets/header.no') }}
                    </button>
                    <button type="submit" class="btn btn-success mb-3">
                        <i class="la la-check"></i>{{ __('locale/widgets/header.yes') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


    <div id="change-password-modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <form action="{{ asset('admin/users/change_password') }}" method="POST" id="change_password_form">
                        @csrf
                        <div class="section-title mt-5 mb-5">
                            <h2 class="text-gradient-02">{{ __('locale/widgets/header.change_password') }}</h2>
                        </div>
                        <div class="group material-input mb-4">
                            <input type="password" name="old_password">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('locale/widgets/header.old_password') }}</label>
                        </div>
                        <div class="group material-input mb-4">
                            <input type="password" name="password">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('locale/widgets/header.new_password') }}</label>
                        </div>
                        <div class="group material-input mb-4">
                            <input type="password" name="password_confirmation">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('locale/widgets/header.confirm_password') }}</label>
                        </div>
                        <div class="button text-center">
                            <button type="submit" class="btn btn-lg btn-gradient-01">
                                {{ __('locale/widgets/header.btn_change') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
