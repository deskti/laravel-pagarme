<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 06/05/2017
 * Time: 15:10
 */

namespace Deskti\Pagarme\app\Facades;


use Illuminate\Support\Facades\Facade;

class FacadeBankAccountService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pagarme.bank.account';
    }
}