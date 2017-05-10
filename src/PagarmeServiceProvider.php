<?php

namespace Deskti\Pagarme;

use Deskti\Pagarme\app\Services\BankAccountService;
use Deskti\Pagarme\app\Services\BankCodeService;
use Deskti\Pagarme\app\Services\CardService;
use Deskti\Pagarme\app\Services\CustomerService;
use Deskti\Pagarme\app\Services\RecipientService;
use Deskti\Pagarme\app\Services\SubscriptionService;
use Deskti\Pagarme\app\Services\TransactionService;
use Deskti\Pagarme\app\Services\UserPagarmeService;
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

        $this->app->singleton('pagarme.recipient',function($app){
            return new RecipientService($app['config']['pagarme']);
        });

        $this->app->singleton('pagarme.bank.account',function($app){
            return new BankAccountService($app['config']['pagarme']);
        });

        $this->app->singleton('pagarme.bank.code',function($app){
            return new BankCodeService();
        });

        $this->app->singleton('pagarme.customer',function($app){
            return new CustomerService($app['config']['pagarme']);
        });

        $this->app->singleton('pagarme.card',function($app){
            return new CardService($app['config']['pagarme']);
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
