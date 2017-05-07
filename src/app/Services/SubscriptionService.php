<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 06/05/2017
 * Time: 14:03
 */

namespace Deskti\PagarMe\app\Services;

use App\Models\User;
use PagarMe\Sdk\Card\Card;
use PagarMe\Sdk\Customer\Customer;
use PagarMe\Sdk\PagarMe;
use PagarMe\Sdk\Plan\Plan;
use PagarMe\Sdk\Subscription\Subscription;
use PagarMe\Sdk\Subscription\SubscriptionHandler;

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
     * @return SubscriptionHandler@get
     */
    public function get($user=null)
    {
        if($user)
            $this->user = $user;

        $this->verifyUser();
        $this->verifySubscription();

        return $this->pagarme->subscription()->get($this->user->subscription_id);
    }

    public function build()
    {

    }

    /**
     * @param Plan $plan
     * @param Card $card
     * @param Customer $customer
     * @param string $postbackUrl
     * @param array $metadata
     */
    public function createCard(
        User $user=null,
        Plan $plan,
        Card $card,
        Customer $customer,
        $postbackUrl = null,
        $metadata = null
    )
    {
        if($user)
            $this->user = $user;

        $this->verifyUser();

        /**
         * Meta data com user_id, pra definir no macro de retorno do pagamento.
         */
        if(!is_array($metadata))
            $metadata = [
                'user_id' => $this->user->id
            ];

        return $this->pagarme->subscription()->createCardSubscription(
            $plan,
            $card,
            $customer,
            $postbackUrl,
            $metadata
        );
    }

    /**
     * @param int $id
     * @param Plan $plan
     * @param Customer $customer
     * @param string $postbackUrl
     * @param array $metadata
     */
    public function createBoleto(
        User $user=null,
        Plan $plan,
        Customer $customer,
        $postbackUrl = null,
        $metadata = null
    ) {
        if($user)
            $this->user = $user;

        $this->verifyUser();

        /**
         * Meta data com user_id, pra definir no macro de retorno do pagamento.
         */
        if(!is_array($metadata))
            $metadata = [
                'user_id' => $this->user->id
            ];

        return $this->pagarme->subscription()->createBoletoSubscription(
            $plan,
            $customer,
            $postbackUrl,
            $metadata
        );
    }

    /**
     * @param int $page
     * @param int $count
     */
    public function getList($page = null, $count = null)
    {
        return $this->pagarme->subscription()->getList($page,$count);
    }

    /**
     * @param Subscription $subscription
     */
    public function cancel(Subscription $subscription)
    {
        return $this->pagarme->subscription()->cancel($subscription);
    }

    /**
     * @param Subscription $subscription
     */
    public function update(Subscription $subscription)
    {
        return $this->pagarme->subscription()->update($subscription);
    }

    /**
     * @param Subscription $subscription
     */
    public function transactions(Subscription $subscription)
    {
        return $this->pagarme->subscription()->transactions($subscription);
    }
}