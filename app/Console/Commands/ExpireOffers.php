<?php

namespace App\Console\Commands;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offers:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change status of expired offers to inactive';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();

        Offer::where('status', 'active')
            ->where('expiration_date', '<', $now)
            ->update(['status' => 'inactive']);

        $this->info('Expired offers have been updated to inactive.');
    }
}