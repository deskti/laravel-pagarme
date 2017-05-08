<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 28/04/2017
 * Time: 23:23
 */

namespace Deskti\Pagarme\src\app\Facades;


use Illuminate\Support\Facades\Facade;

class FacadeUserPagarmeService extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'pagarme';
    }
}