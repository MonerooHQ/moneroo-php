<?php

namespace Moneroo;

final class Payout extends Moneroo
{
    public function init(array $data)
    {
        return $this->sendRequest('post', $data, 'payouts/initialize');
    }

    public function verify(string $payoutTransactionId)
    {
        return $this->sendRequest('get', [], 'payouts/' . $payoutTransactionId . '/verify');
    }

    public function get(string $payoutTransactionId)
    {
        return $this->sendRequest('get', [], 'payouts/' . $payoutTransactionId);
    }
}
