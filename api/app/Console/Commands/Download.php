<?php

namespace App\Console\Commands;

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
            DB::beginTransaction();

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
                $this->line("downloading data of the day: {$date->format('Y-m-d')}");
                $page = 1;
                $last_page = 1;
                $break = false;
                while (!$break) {
                    try {
                        $url = "https://arquivos.b3.com.br/tabelas/table/LendingOpenPosition/{$date->format('Y-m-d')}/{$page}";

                        $response = Http::timeout(60)->get($url);

                        if (!$response->ok()) {
                            $this->error("Error downloading page data {$page}: {$response->status()} {$response->body()}");
                            return;
                        }

                        $item = json_decode($response->body());

                        if ($page === 1 && !empty($item->pageCount)) $last_page = $item->pageCount;

                        if (!empty($item->values)) {
                            $items = $item->values;

                            foreach ($items as $item) {
                                LendingOpenPosition::create([
                                    'date' => $item[0],
                                    'paper' => $item[1],
                                    'asset_role' => $item[2],
                                    'balance_amount' => $item[3],
                                    'average_price' => $item[4],
                                    'price_factor' => $item[5],
                                    'total_balance' => $item[6],
                                ]);
                            }

                            $percent_done = ($page) / $last_page * 100;
                            $this->output->write("\x0D");
                            if ($percent_done === 100) {
                                $this->output->write(sprintf("Progress: %.2f%%\n", $percent_done));
                            } else {
                                $this->output->write(sprintf("Progress: %.2f%%", $percent_done));
                            }

                        } else {
                            $this->error("there is no data to download");
                        }

                        if ($last_page === $page || !$last_page) {
                            $break = true; // No more data on this page
                        }

                        $page++;

                        sleep(rand(2, 4));
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                }
            }

            DB::commit();

            $this->info('Data successfully downloaded!');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->error($th);
            return;
        }
    }
}
