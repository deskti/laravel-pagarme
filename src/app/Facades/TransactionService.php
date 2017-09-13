<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 06/05/2017
 * Time: 15:10
 */

namespace Deskti\Pagarme\src\app\Facades;


use Illuminate\Support\Facades\Facade;

class SubscriptionService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pagarme.subscription';
    }
}