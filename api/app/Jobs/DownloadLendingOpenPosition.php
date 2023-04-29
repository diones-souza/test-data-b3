<?php

namespace App\Jobs;

use App\Models\LendingOpenPosition;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DownloadLendingOpenPosition implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300;

    private $date;

    /**
     * Create a new job instance.
     */
    public function __construct(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();

            $page = 1;
            $last_page = 1;
            $break = false;
            while (!$break) {
                try {
                    $url = "https://arquivos.b3.com.br/tabelas/table/LendingOpenPosition/{$this->date->format('Y-m-d')}/{$page}";

                    $response = Http::timeout(60)->get($url);

                    if (!$response->ok()) {
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

            DB::commit();
            return;
        } catch (\Throwable $th) {
            DB::rollback();
            return;
        }
    }
}
