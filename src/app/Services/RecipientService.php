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


class RecipientService extends Dependecies
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
        BankAccount $bankAccount,
        $transferInterval = null,
        $transferDay = null,
        $transferEnabled = null,
        $automaticAnticipationEnabled = null,
        $anticipatableVolumePercentage = null
    )
    {
        if( $user )
            $this->user = $user;

        $this->verifyUser();

        return $this->pagarme->recipient()->create(
            $bankAccount,
            $transferInterval,
            $transferDay,
            $transferEnabled,
            $automaticAnticipationEnabled,
            $anticipatableVolumePercentage
        );
    }

    public function get($recipient_id)
    {
        $this->verifyUser();

        return $this->pagarme->recipient()->get($recipient_id);
    }
}