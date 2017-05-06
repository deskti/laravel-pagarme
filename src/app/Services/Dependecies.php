<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 06/05/2017
 * Time: 14:58
 */

namespace Packets\PagarMe\src\app\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Packets\PagarMe\src\app\Exceptions\CustomPagarmeException;

class Dependecies
{
    public $user;

    function __construct()
    {
        $this->user = Auth::check() ? Auth::user() :
            Auth::guard('api')->check() ? Auth::guard('api')->user() : new User();
    }

    public function verifyUser()
    {
        if( !$this->user )
            throw new CustomPagarmeException('User not Found');

    }

    public function verifySubscription()
    {
        if( !$this->user->subscription_id || $this->user->subscription_id == "" )
            throw new CustomPagarmeException('Subscription not Defined in User');
    }
}