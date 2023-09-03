<?php

namespace Moneroo;

class Payment extends Moneroo
{
    public function init(array $data)
    {
        return $this->sendRequest('post', $data, 'payments/initialize');
    }

    public function verify(string $paymentTransactionId)
    {
        return $this->sendRequest('get', [], 'payments/' . $paymentTransactionId . '/verify');
    }

    public function get(string $paymentTransactionId)
    {
        return $this->sendRequest('get', [], 'payments/' . $paymentTransactionId);
    }

    public function markAsProcessed(string $paymentTransactionId)
    {
        return $this->sendRequest('post', [], 'payments/' . $paymentTransactionId . '/process');
    }
}
