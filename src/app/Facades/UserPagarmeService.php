<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 28/04/2017
 * Time: 23:23
 */

namespace Deskti\PagarMe\src\app\Facades;


use Illuminate\Support\Facades\Facade;

class UserPagarmeService extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'pagarme';
    }
}