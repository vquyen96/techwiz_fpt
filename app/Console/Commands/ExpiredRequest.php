<?php
namespace App\Console\Commands;

use App\Services\System\RequestExpiredServiceInterface;
use Illuminate\Console\Command;

class ExpiredRequest extends Command
{
    private $requestExpiredService;

    protected $signature = 'command:request-expired';

    protected $description = 'Command description';

    public function __construct(RequestExpiredServiceInterface $requestExpiredService)
    {
        parent::__construct();
        $this->requestExpiredService = $requestExpiredService;
    }

    public function handle()
    {
        $this->requestExpiredService->expiredRequest();
    }
}
