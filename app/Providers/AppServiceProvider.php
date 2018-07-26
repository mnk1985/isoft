<?php

namespace App\Providers;

use App\Console\Commands\CalculateTransactionsPreviousDaySummary;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Repositories\CustomersRepository;
use App\Repositories\TransactionsRepository;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(CustomerController::class)
            ->needs(RepositoryInterface::class)
            ->give(CustomersRepository::class);

        $this->app->when(CalculateTransactionsPreviousDaySummary::class)
            ->needs(RepositoryInterface::class)
            ->give(TransactionsRepository::class);

        $this->app->when(TransactionController::class)
            ->needs(RepositoryInterface::class)
            ->give(TransactionsRepository::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
