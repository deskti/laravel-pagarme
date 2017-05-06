<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 06/05/2017
 * Time: 14:03
 */

namespace Packets\PagarMe\src\app\Services;

use PagarMe\Sdk\PagarMe;

class SubscriptionService extends Dependecies
{
    public $user;
    private $config;
    public $pagarme;

    public function __construct($config)
    {
        parent::__construct();

        $this->pagarme = new PagarMe($config['credentials'][$config['mode']]['key']);
        $this->config = $config;
    }

    /**
     * @param null $user
     * @return \PagarMe\Sdk\Subscription\Subscription
     */
    public function get($user=null)
    {
        if($user)
            $this->user = $user;

        $this->verifyUser();
        $this->verifySubscription();

        return $this->pagarme->subscription()->get($this->user->subscription_id);
    }
}