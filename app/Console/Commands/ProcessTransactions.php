<?php

namespace App\Console\Commands;

use App\Services\CommissionCalculatorService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ProcessTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:process {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process transactions';

    public function __construct(private readonly CommissionCalculatorService $commissionCalculatorService) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        try {
            $data = $this->commissionCalculatorService->handle($filePath);
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());

            return;
        }

        foreach ($data as $item) {
            if (Arr::get($item, 'error')) {
                $this->error('Error while calculating transaction.' . Arr::get($item, 'data'));
            } else {
                $this->info(round(Arr::get($item, 'data'), 2));
            }
        }
    }
}
