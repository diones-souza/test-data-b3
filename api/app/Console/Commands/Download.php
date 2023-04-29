<?php

namespace App\Console\Commands;

use App\Jobs\DownloadLendingOpenPosition;
use App\Models\LendingOpenPosition;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Download extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:download {start_date} {end_date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads data between start and end dates.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $start_date = $this->argument('start_date');
            $end_date = $this->argument('end_date') ?? $start_date;

            try {
                // Check that the dates provided are valid
                $start_date = DateTime::createFromFormat('Y-m-d', $start_date);
                $end_date = DateTime::createFromFormat('Y-m-d', $end_date);
                $end_date->modify('+1 day');
            } catch (\Throwable $th) {
                $this->error('The provided dates are not valid. Make sure they are in Y-m-d format.');
                return;
            }

            $interval = new DateInterval('P1D'); // interval 1 day
            $period = new DatePeriod($start_date, $interval, $end_date);

            foreach ($period as $date) {
                $this->line("added to queue the day: {$date->format('Y-m-d')}");
                DownloadLendingOpenPosition::dispatch($date)->onQueue('download');
            }

            DB::commit();

            $this->info('Data download added to queue!');
        } catch (\Throwable $th) {
            $this->error($th);
            return;
        }
    }
}
