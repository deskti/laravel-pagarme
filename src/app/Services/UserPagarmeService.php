<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 05/04/2017
 * Time: 12:43
 */

namespace Packets\PagarMe\src\app\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Packets\PagarMe\src\app\Exceptions\CustomPagarmeException;
use PagarMe\Sdk\Card\Card;
use PagarMe\Sdk\Customer\Customer;
use PagarMe\Sdk\PagarMe;
use PagarMe\Sdk\Plan\Plan;

class UserPagarmeService extends Dependecies
{
    public $user;
    private $config;
    public $pagarme;

    public $subscription;

    function __construct($config)
    {
        parent::__construct();

        $this->pagarme = new PagarMe($config['credentials'][$config['mode']]['key']);
        $this->config = $config;
    }

    /**
     * @return PagarMe
     */
    public function pagarmeProvider()
    {
        return $this->pagarme;
    }

    public function __call($name, $arguments)
    {
        if( !$this->user )
            throw new CustomPagarmeException('Not called '.$name.' User not Found in '.$arguments);
    }

    /**
     * @return User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUser()
    {
        $this->verifyUser();

        return $this->user;
    }

    public function getConfig()
    {
        $this->verifyUser();

        return $this->config;
    }

    /**
     * @param null $user
     * @return \PagarMe\Sdk\Subscription\Subscription
     */
    public function getSubscription($user=null)
    {
        if($user)
            $this->user = $user;

        $this->verifyUser();
        $this->verifySubscription();

        return $this->pagarmeProvider()->subscription()->get($this->user->subscription_id);
    }


    public function getCustomer($user=null)
    {
        if($user)
            $this->user = $user;

        $customer = $this->getSubscription($this->user)->getCustomer();
        return $this->pagarme->customer()->get($customer->getId());
    }


    public function getSubscriptions()
    {
        $this->verifyUser();
        $this->verifySubscription();

        return $this->pagarme->subscription()->getList();
    }

    public function getPlan()
    {
        $this->verifyUser();
        $this->verifySubscription();

        return $this->pagarme->plan()->get($this->getSubscription()->getPlan()->getId());
    }

    public function subscriptionStatus($type="active",$user=null)
    {
        if($user)
            $this->user = $user;

        $this->verifyUser();
        $this->verifySubscription();

        foreach($this->config['subscription']['body']['status'][$type] as $key => $status)
        {
            if($this->getSubscription()->getStatus() == $key)
            {
                if(Auth::guard('api')->check())
                {
                    return response()->json([$status=>true]);
                } else {
                    return true;
                }

            }

        }

        if(Auth::guard('api')->check())
        {
            return response()->json([$type=>true]);
        } else {
            return true;
        }
    }

    public function subscriptionStatusName($user=null)
    {
        if($user)
            $this->user = $user;

        $this->verifyUser();
        $this->verifySubscription();

        foreach($this->config['subscription']['body']['status'] as $type)
        {
            foreach( $type as $key => $status )
            {
                if($this->getSubscription()->getStatus() == $key)
                {
                    if(Auth::guard('api')->check())
                    {
                        return response()->json(['status'=>$status]);
                    } else {
                        return $status;
                    }
                }
            }

        }

        if(Auth::guard('api')->check())
        {
            return response()->json(['status'=>'Not defined']);
        } else {
            return 'Not defined';
        }
    }

    public function updateCardSubscription(Request $request,$user=null)
    {
        $card = $this->pagarme->card()->create(
            $request->card_number,
            $request->holder_name,
            $request->card_expiration
        );
        $this->pagarme->subscription()->update(
            $this->getSubscription()
        )->setCard($card);
    }

    public function createCardSubscription(
        Plan $plan,
        Card $card,
        Customer $customer,
        User $user=null,
        $posback=null,
        $paramters=null
    )
    {
        if($user)
            $this->user = $user;

        $subscription = $this->pagarme->subscription()->createCardSubscription(
            $plan,
            $card,
            $customer,
            $posback,
            $paramters
        );

        return $subscription;
    }

    /**
     * @param $cep
     * @return \PagarMe\Sdk\Zipcode\ZipcodeHandler
     */
    public function cep($cep)
    {
        return $this->pagarme->zipcode()->getInfo($cep);
    }
}