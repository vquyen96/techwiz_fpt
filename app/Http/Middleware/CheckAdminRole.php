<?php

namespace App\Http\Middleware;

use App\Enums\User\Role;
use App\Repositories\NotificationAdminRepository;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CheckAdminRole
{
    private $notiAdminRepository;

    public function __construct(NotificationAdminRepository $notiAdminRepository)
    {
        $this->notiAdminRepository = $notiAdminRepository;
    }

    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role !== Role::ADMIN) {
            abort(404);
        }

//        $notiAdmin =  $this->notiAdminRepository->getNotification();
//        View::share('notiAdmin', $notiAdmin);
//        $countNoti = $this->notiAdminRepository->getCountUnread();
//        View::share('countNoti', $countNoti);

        return $next($request);
    }
}
