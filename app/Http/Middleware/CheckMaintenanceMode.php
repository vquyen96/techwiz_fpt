<?php

namespace App\Http\Middleware;

use App\Services\Admin\SystemServiceInterface;
use Closure;

class CheckMaintenanceMode
{
    private $systemService;

    public function __construct(
        SystemServiceInterface $systemService
    ) {
        $this->systemService = $systemService;
    }

    public function handle($request, Closure $next)
    {
//        if ($this->systemService->isMaintenanceMode()) {
//            return [
//                'status' => 'maintenance',
//                'end_time' => $this->systemService->getCurrentMaintenanceData()->first()->end_time
//            ];
//        }

        return $next($request);
    }
}
