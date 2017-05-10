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
use PagarMe\Sdk\PagarMe;


class BankAccountService extends Dependecies
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
        $bankCode,
        $officeNumber,
        $accountNumber,
        $accountDigit,
        $documentNumber,
        $legalName,
        $officeDigit = null,
        $type = null
    )
    {
        if( $user )
            $this->user = $user;

        $this->verifyUser();

        return $this->pagarme->bankAccount()->create(
            $bankCode,
            $officeNumber,
            $accountNumber,
            $accountDigit,
            $documentNumber,
            $legalName,
            $officeDigit,
            $type
        );
    }

    public function get($bankAccount_id)
    {
        $this->verifyUser();

        return $this->pagarme->bankAccount()->get($bankAccount_id);
    }
}