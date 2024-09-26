<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckOrderStatus extends Command
{
    protected $signature = 'orders:check-status';
    protected $description = 'Check the status of orders from an external URL';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $url = 'http://pkl-toko-online.test:90/user/order?status=';

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $this->info('Successfully checked order status.');
            } else {
                $this->error('Failed to check order status.');
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}
