<?php

namespace Deskti\Pagarme\app\Contracts;


use Deskti\Pagarme\app\Services\UserPagarmeService;
use PagarMe\Sdk\PagarMe;

interface CashierServiceContracts
{

    /**
     * @return PagarMe
     */
    public function pagarmeProvider();

    /**
     * @param $user User
     * @return UserPagarmeService
     */
    public function getSubscription($user=null);

    /**
     * @return UserPagarmeService
     */
    public function getPlan();

    /**
     * @param $status
     * @return UserPagarmeService
     */
    public function subscriptionStatus($type,User $user);

    public function subscriptionStatusName(User $user);

    public function getUser();

    public function getConfig();

    public function updateCardSubscription($request,User $user=null);

    /**
     * @param $plan
     * @param $card
     * @param $customer
     * @param $user User
     * @param null $posback
     * @param array $paramters
     * @return mixed
     */
    public function createCardSubscription(
        $plan,
        $card,
        $customer,
        $user=null,
        $posback=null,
        $paramters=['meta'=>[]]
    );

    /**
     * @param $user
     * @return \PagarMe\Sdk\Customer\Customer
     */
    public function getCustomer($user);

}