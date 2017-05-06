<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 06/05/2017
 * Time: 15:10
 */

namespace Packets\PagarMe\src\app\Facades;


use Illuminate\Support\Facades\Facade;

class TransactionService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pagarme.transaction';
    }
}