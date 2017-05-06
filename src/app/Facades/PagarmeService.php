<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 06/05/2017
 * Time: 15:10
 */

namespace Deskti\PagarMe\app\Facades;


use Illuminate\Support\Facades\Facade;

class PagarmeService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pagarme.provider';
    }
}