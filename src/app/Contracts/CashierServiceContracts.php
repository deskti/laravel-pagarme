<?php
namespace Packets\PagarMe\src\app\Contracts;


use App\Models\User;
use Packets\PagarMe\src\app\Services\UserPagarmeService;
use PagarMe\Sdk\PagarMe;

interface CashierServiceContracts
{

    /**
     * @return PagarMe
     */
    public function pagarmeProvider();

    /**
     * @return UserPagarmeService
     */
    public function getSubscription(User $user=null);

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

    public function createCardSubscription(
        $plan,
        $card,
        $customer,
        User $user=null,
        $posback=null,
        $paramters=['meta'=>[]]
    );

    /**
     * @param $user
     * @return \PagarMe\Sdk\Customer\Customer
     */
    public function getCustomer($user);

}