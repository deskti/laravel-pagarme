<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 06/05/2017
 * Time: 15:04
 */

namespace Packets\PagarMe\src\app\Services;


use App\Models\User;
use PagarMe\Sdk\PagarMe;
use PagarMe\Sdk\Transaction\CreditCardTransaction;

class TransactionService extends Dependecies
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
     * @return \PagarMe\Sdk\Transaction\BoletoTransaction | CreditCardTransaction
     */
    public function get($transaction_id,User $user=null)
    {
        if($user)
            $this->user = $user;

        $this->verifyUser();

        return $this->pagarme->transaction()->get($transaction_id);
    }
}