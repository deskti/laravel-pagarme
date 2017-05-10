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


class CardService extends Dependecies
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
        $cardNumber,
        $holderName,
        $cardExpirationDate
    )
    {
        if( $user )
            $this->user = $user;

        $this->verifyUser();

        return $this->pagarme->card()->create(
            $cardNumber,
            $holderName,
            $cardExpirationDate
        );
    }

    public function createFromHash($card_hash)
    {
        return $this->pagarme->card()->createFromHash($card_hash);
    }

    public function get($customer_id)
    {
        $this->verifyUser();

        return $this->pagarme->customer()->get($customer_id);
    }
}