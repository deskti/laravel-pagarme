<?php
/**
 * Created by PhpStorm.
 * User: Servidor
 * Date: 06/05/2017
 * Time: 15:04
 */

namespace Deskti\Pagarme\app\Services;

use PagarMe\Sdk\Card\Card;
use PagarMe\Sdk\Customer\Customer;
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
    public function get($transaction_id,$user=null)
    {
        if($user)
            $this->user = $user;

        $this->verifyUser();

        return $this->pagarme->transaction()->get($transaction_id);
    }

    /**
     * @param int $amount
     * @param \PagarMe\Sdk\Card\Card $card
     * @param \PagarMe\Sdk\Customer\Customer $customer
     * @param int $installments
     * @param boolean $capture
     * @param string $postBackUrl
     * @param array $metaData
     * @param array $extraAttributes
     * @return CreditCardTransaction
     */
    public function creditCardTransaction(
        $user=null,
        $amount,
        Card $card,
        Customer $customer,
        $installments = 1,
        $capture = true,
        $postBackUrl = null,
        $metadata = null,
        $extraAttributes = []
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

        return $this->pagarme->transaction()->creditCardTransaction(
            $amount,
            $card,
            $customer,
            $installments,
            $capture,
            $postBackUrl,
            $metadata,
            $extraAttributes
        );
    }

    /**
     * @param int $amount
     * @param \PagarMe\Sdk\Customer\Customer $customer
     * @param string $postBackUrl
     * @param array $extraAttributes
     * @return BoletoTransaction
     */
    public function boletoTransaction(
        $user = null,
        $amount,
        Customer $customer,
        $postBackUrl,
        $metadata = null,
        $extraAttributes = []
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

        return $this->pagarme->transaction()->boletoTransaction(
            $amount,
            $customer,
            $postBackUrl,
            $metadata,
            $extraAttributes
        );
    }
}