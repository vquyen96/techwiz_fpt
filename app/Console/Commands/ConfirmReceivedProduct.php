<?php
namespace App\Console\Commands;

use App\Services\System\ConfirmReceivedService;
use Illuminate\Console\Command;

class ConfirmReceivedProduct extends Command
{
    private $confirmReceivedService;

    protected $signature = 'command:confirm-received-product';

    protected $description = 'Confirm received product';

    public function __construct(ConfirmReceivedService $confirmReceivedService)
    {
        parent::__construct();
        $this->confirmReceivedService = $confirmReceivedService;
    }

    public function handle()
    {
        $this->confirmReceivedService->confirmReceived();
    }
}
