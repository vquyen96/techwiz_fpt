<?php

namespace App\Console\Commands;

use App\Services\System\CronJobServiceInterface;
use Illuminate\Console\Command;

class StopSellingProduct extends Command
{

    private $cronJobService;

    protected $signature = 'command:check-stop-sell';

    protected $description = 'Command description';

    public function __construct(CronJobServiceInterface $cronJobService)
    {
        parent::__construct();
        $this->cronJobService = $cronJobService;
    }

    public function handle()
    {
        $this->cronJobService->stopSellingProduct();
    }
}
