<?php

namespace App\Console\Commands;

use App\Repositories\TransactionsRepository;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CalculateTransactionsPreviousDaySummary extends Command
{
    const FILE_NAME = 'sum.txt';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:calculate-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'calculate summary on transactions from previous day';
    /**
     * @var TransactionsRepository
     */
    private $transactions;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(RepositoryInterface $transactions)
    {
        parent::__construct();
        $this->transactions = $transactions;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sum = $this->transactions->getPreviousDaySummary();

        Storage::put(self::FILE_NAME, $sum);

        return true;
    }
}
