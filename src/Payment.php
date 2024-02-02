<?php

namespace Moneroo;

final class Payment extends Moneroo
{
    /**
     * Initialize payment.
     *
     * @param array $data - Array of data to be sent
     *
     * @see https://docs.moneroo.io/sdks/php#initialize-payment
     */
    public function init(array $data)
    {
        return $this->sendRequest('post', $data, 'payments/initialize');
    }

    /**
     * Verify payment.
     *
     * @param string $paymentTransactionId - Payment transaction id
     *
     * @see https://docs.moneroo.io/sdks/php#verify-payment
     */
    public function verify(string $paymentTransactionId)
    {
        return $this->sendRequest('get', [], "payments/{$paymentTransactionId}/verify");
    }

    /**
     * Retrieve payment details.
     *
     * @param string $paymentTransactionId - Payment transaction id
     *
     * @see https://docs.moneroo.io/sdks/php#retrieve-payment
     */
    public function get(string $paymentTransactionId)
    {
        return $this->sendRequest('get', [], "payments/{$paymentTransactionId}");
    }

    /**
     * Mark payment as processed.
     *
     * @param string $paymentTransactionId - Payment transaction id
     *
     * @see https://docs.moneroo.io/sdks/php#mark-payment-as-processed api-docs.vercel.app/sdks/php#mark-payment-as-processed
     */
    public function markAsProcessed(string $paymentTransactionId)
    {
        return $this->sendRequest('post', [], "payments/{$paymentTransactionId}/process");
    }
}
