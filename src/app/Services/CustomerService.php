<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 06/05/2017
 * Time: 14:03
 */

namespace Deskti\Pagarme\app\Services;

use App\Models\User;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Customer\Address;
use PagarMe\Sdk\Customer\Phone;
use PagarMe\Sdk\PagarMe;


class CustomerService extends Dependecies
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

    public function create(
        User $user,
        $name,
        $email,
        $documentNumber,
        Address $address,
        Phone $phone,
        $bornAt = null,
        $gender = null
    )
    {
        if( $user )
            $this->user = $user;

        $this->verifyUser();

        return $this->pagarme->customer()->create(
            $name,
            $email,
            $documentNumber,
            $address,
            $phone,
            $bornAt,
            $gender
        );
    }

    public function get($customer_id)
    {
        $this->verifyUser();

        return $this->pagarme->customer()->get($customer_id);
    }
}