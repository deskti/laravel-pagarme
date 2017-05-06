<?php

namespace Packets\PagarMe\src;

use Packets\PagarMe\src\app\Services\SubscriptionService;
use Packets\PagarMe\src\app\Services\TransactionService;
use Packets\PagarMe\src\app\Services\UserPagarmeService;
use Illuminate\Support\ServiceProvider;
use PagarMe\Sdk\PagarMe;

class PagarmeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/pagarme.php' => config_path('pagarme.php'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('pagarme',function($app){
            return new UserPagarmeService($app['config']['pagarme']);
        });

        $this->app->singleton('pagarme.provider',function($app){
            return new PagarMe($app['config']['pagarme']['credentials'][$app['config']['pagarme']['mode']]['key']);
        });

        $this->app->singleton('pagarme.subscription',function($app){
            return new SubscriptionService($app['config']['pagarme']);
        });

        $this->app->singleton('pagarme.transaction',function($app){
            return new TransactionService($app['config']['pagarme']);
        });

        $this->app->bind(
            'Packets\PagarMe\src\app\Contracts\CashierServiceContracts',
            'pagarme'
        );

        $this->mergeConfigFrom(
            __DIR__.'/config/pagarme.php', 'pagarme'
        );
    }
}
